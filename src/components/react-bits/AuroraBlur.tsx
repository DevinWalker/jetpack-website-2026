"use client";

import React, { useRef, useMemo } from "react";
import { Canvas, useFrame, useThree } from "@react-three/fiber";
import * as THREE from "three";

export interface AuroraLayer {
  color: string;
  speed: number;
  intensity: number;
}

export interface SkyLayer {
  color: string;
  blend: number;
}

// Defaults customized for the Jetpack theme — greens + lime on a soft green-0
// sky so the hero aurora reads as brand palette rather than stock purple.
// Override per-instance by passing `layers` / `skyLayers` props.
const defaultLayers: AuroraLayer[] = [
  { color: "#22c55e", speed: 0.25, intensity: 0.6 },
  { color: "#16a34a", speed: 0.12, intensity: 0.5 },
  { color: "#4ade80", speed: 0.18, intensity: 0.35 },
  { color: "#069e08", speed: 0.08, intensity: 0.25 },
];

const defaultSkyLayers: SkyLayer[] = [
  { color: "#f0f6e8", blend: 0.55 },
  { color: "#ffffff", blend: 0.55 },
];

export interface AuroraBlurProps {
  width?: string | number;
  height?: string | number;
  className?: string;
  children?: React.ReactNode;
  speed?: number;
  layers?: AuroraLayer[];
  noiseScale?: number;
  movementX?: number;
  movementY?: number;
  verticalFade?: number;
  bloomIntensity?: number;
  skyLayers?: SkyLayer[];
  brightness?: number;
  saturation?: number;
  opacity?: number;
}

const vertexShader = `
varying vec2 vUv;
void main() {
  vUv = uv;
  gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
}
`;

const fragmentShader = `
precision highp float;
varying vec2 vUv;
uniform float u_time;
uniform vec2 u_resolution;
uniform float u_speed;
uniform vec3 u_layer1Color;
uniform float u_layer1Speed;
uniform float u_layer1Intensity;
uniform vec3 u_layer2Color;
uniform float u_layer2Speed;
uniform float u_layer2Intensity;
uniform vec3 u_layer3Color;
uniform float u_layer3Speed;
uniform float u_layer3Intensity;
uniform vec3 u_layer4Color;
uniform float u_layer4Speed;
uniform float u_layer4Intensity;
uniform float u_noiseScale;
uniform float u_movementX;
uniform float u_movementY;
uniform float u_verticalFade;
uniform float u_bloomIntensity;
uniform vec3 u_skyColor1;
uniform vec3 u_skyColor2;
uniform float u_skyBlend1;
uniform float u_skyBlend2;
uniform float u_brightness;
uniform float u_saturation;
uniform float u_opacity;

float h(float n){return fract(sin(n)*43758.5453);}

float n2d(vec2 p){
  vec2 i=floor(p),f=fract(p),u=f*f*(3.-2.*f);
  return mix(mix(h(i.x+h(i.y)),h(i.x+1.+h(i.y)),u.x),
             mix(h(i.x+h(i.y+1.)),h(i.x+1.+h(i.y+1.)),u.x),u.y);
}

vec3 aurora(vec2 uv,float spd,float intensity,vec3 col,float aspect){
  float t=u_time*u_speed*spd;
  vec2 scaled=vec2(uv.x*aspect,uv.y)*u_noiseScale;
  vec2 p=scaled+t*vec2(u_movementX,u_movementY);
  float n=n2d(p+n2d(col.xy+p+t));
  // Clamp a to 0 so negative contributions cant subtract channels from the
  // sky (which would produce complementary-color halos: greens read as
  // magenta wherever a drops below zero).
  float a=max(n-uv.y*u_verticalFade,0.0);
  return col*a*intensity*u_bloomIntensity;
}

vec3 sat(vec3 c,float s){
  float g=dot(c,vec3(0.299,0.587,0.114));
  return mix(vec3(g),c,s);
}

void main(){
  vec2 uv=vUv;
  float aspect=u_resolution.x/u_resolution.y;

  // Only sum the aurora layers \u2014 we intentionally skip the stock
  // sky-gradient backdrop (which darkens toward the top and clashes with
  // light-themed pages). Alpha is derived from luminance, so pixels with
  // no aurora contribution are fully transparent and the host page
  // background shows through cleanly.
  vec3 c=vec3(0.);
  c+=aurora(uv,u_layer1Speed,u_layer1Intensity,u_layer1Color,aspect);
  c+=aurora(uv,u_layer2Speed,u_layer2Intensity,u_layer2Color,aspect);
  c+=aurora(uv,u_layer3Speed,u_layer3Intensity,u_layer3Color,aspect);
  c+=aurora(uv,u_layer4Speed,u_layer4Intensity,u_layer4Color,aspect);

  c=sat(c,u_saturation)*u_brightness;

  float luminance=clamp(dot(c,vec3(0.299,0.587,0.114)),0.0,1.0);
  gl_FragColor=vec4(c, luminance*u_opacity);
}
`;

function hexToVec3(hex: string): [number, number, number] {
  const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
  if (!result) return [1, 1, 1];
  return [
    parseInt(result[1], 16) / 255,
    parseInt(result[2], 16) / 255,
    parseInt(result[3], 16) / 255,
  ];
}

interface SceneProps {
  speed: number;
  layers: AuroraLayer[];
  noiseScale: number;
  movementX: number;
  movementY: number;
  verticalFade: number;
  bloomIntensity: number;
  skyLayers: SkyLayer[];
  brightness: number;
  saturation: number;
  opacity: number;
}

const Scene: React.FC<SceneProps> = ({
  speed,
  layers,
  noiseScale,
  movementX,
  movementY,
  verticalFade,
  bloomIntensity,
  skyLayers,
  brightness,
  saturation,
  opacity,
}) => {
  const meshRef = useRef<THREE.Mesh>(null);
  const { size } = useThree();

  const uniforms = useMemo(
    () => ({
      u_time:            { value: 0 },
      u_resolution:      { value: new THREE.Vector2(1, 1) },
      u_speed:           { value: 1 },
      // Seeded with Jetpack-green defaults so the first paint matches the
      // brand palette even before useFrame has had a chance to run.
      u_layer1Color:     { value: new THREE.Vector3( 0.024, 0.62, 0.031 ) }, // #069e08
      u_layer1Speed:     { value: 0.25 },
      u_layer1Intensity: { value: 0.45 },
      u_layer2Color:     { value: new THREE.Vector3( 0.0, 0.443, 0.09 ) },   // #007117
      u_layer2Speed:     { value: 0.12 },
      u_layer2Intensity: { value: 0.35 },
      u_layer3Color:     { value: new THREE.Vector3( 0.659, 0.851, 0.275 ) }, // #a8d946
      u_layer3Speed:     { value: 0.18 },
      u_layer3Intensity: { value: 0.25 },
      u_layer4Color:     { value: new THREE.Vector3( 0.024, 0.62, 0.031 ) }, // #069e08
      u_layer4Speed:     { value: 0.08 },
      u_layer4Intensity: { value: 0.15 },
      u_noiseScale:      { value: 2.5 },
      u_movementX:       { value: -1 },
      u_movementY:       { value: -1.5 },
      u_verticalFade:    { value: 0.85 },
      u_bloomIntensity:  { value: 1.4 },
      u_skyColor1:       { value: new THREE.Vector3( 0.941, 0.965, 0.91 ) },  // #f0f6e8
      u_skyColor2:       { value: new THREE.Vector3( 1, 1, 1 ) },             // #ffffff
      u_skyBlend1:       { value: 0.55 },
      u_skyBlend2:       { value: 0.55 },
      u_brightness:      { value: 0.95 },
      u_saturation:      { value: 1.1 },
      u_opacity:         { value: 0.55 },
    }),
    [],
  );

  useFrame((state) => {
    if (!meshRef.current) return;
    const material = meshRef.current.material as THREE.ShaderMaterial;
    material.uniforms.u_time.value = state.clock.elapsedTime;
    material.uniforms.u_resolution.value.set(size.width, size.height);
    material.uniforms.u_speed.value = speed;
    const l = layers;
    material.uniforms.u_layer1Color.value.set(...hexToVec3(l[0]?.color || "#000"));
    material.uniforms.u_layer1Speed.value = l[0]?.speed || 0;
    material.uniforms.u_layer1Intensity.value = l[0]?.intensity || 0;
    material.uniforms.u_layer2Color.value.set(...hexToVec3(l[1]?.color || "#000"));
    material.uniforms.u_layer2Speed.value = l[1]?.speed || 0;
    material.uniforms.u_layer2Intensity.value = l[1]?.intensity || 0;
    material.uniforms.u_layer3Color.value.set(...hexToVec3(l[2]?.color || "#000"));
    material.uniforms.u_layer3Speed.value = l[2]?.speed || 0;
    material.uniforms.u_layer3Intensity.value = l[2]?.intensity || 0;
    material.uniforms.u_layer4Color.value.set(...hexToVec3(l[3]?.color || "#000"));
    material.uniforms.u_layer4Speed.value = l[3]?.speed || 0;
    material.uniforms.u_layer4Intensity.value = l[3]?.intensity || 0;
    material.uniforms.u_noiseScale.value = noiseScale;
    material.uniforms.u_movementX.value = movementX;
    material.uniforms.u_movementY.value = movementY;
    material.uniforms.u_verticalFade.value = verticalFade;
    material.uniforms.u_bloomIntensity.value = bloomIntensity;
    material.uniforms.u_skyColor1.value.set(...hexToVec3(skyLayers[0]?.color || "#000"));
    material.uniforms.u_skyColor2.value.set(...hexToVec3(skyLayers[1]?.color || "#000"));
    material.uniforms.u_skyBlend1.value = skyLayers[1]?.blend || 0;
    material.uniforms.u_skyBlend2.value = skyLayers[0]?.blend || 0;
    material.uniforms.u_brightness.value = brightness;
    material.uniforms.u_saturation.value = saturation;
    material.uniforms.u_opacity.value = opacity;
  });

  return (
    <mesh ref={meshRef}>
      <planeGeometry args={[2, 2]} />
      <shaderMaterial
        vertexShader={vertexShader}
        fragmentShader={fragmentShader}
        uniforms={uniforms}
        transparent={true}
      />
    </mesh>
  );
};

const AuroraBlur: React.FC<AuroraBlurProps> = ({
  width = "100%",
  height = "100%",
  className,
  children,
  speed = 1.5,
  layers = defaultLayers,
  noiseScale = 3.5,
  movementX = -2,
  movementY = -3,
  verticalFade = 0.75,
  bloomIntensity = 2,
  skyLayers = defaultSkyLayers,
  brightness = 0.8,
  saturation = 1,
  opacity = 1,
}) => {
  const widthStyle = typeof width === "number" ? `${width}px` : width;
  const heightStyle = typeof height === "number" ? `${height}px` : height;

  return (
    <div
      className={`relative overflow-hidden ${className || ""}`}
      style={{ width: widthStyle, height: heightStyle }}
    >
      <Canvas
        className="absolute inset-0 w-full h-full"
        gl={{ antialias: true, alpha: true }}
        orthographic
        camera={{ position: [0, 0, 1], zoom: 1, left: -1, right: 1, top: 1, bottom: -1 }}
      >
        <Scene
          speed={speed}
          layers={layers}
          noiseScale={noiseScale}
          movementX={movementX}
          movementY={movementY}
          verticalFade={verticalFade}
          bloomIntensity={bloomIntensity}
          skyLayers={skyLayers}
          brightness={brightness}
          saturation={saturation}
          opacity={opacity}
        />
      </Canvas>
      {children && <div className="relative z-10">{children}</div>}
    </div>
  );
};

AuroraBlur.displayName = "AuroraBlur";

export default AuroraBlur;
