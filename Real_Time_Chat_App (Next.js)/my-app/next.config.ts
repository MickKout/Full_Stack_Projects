import type { NextConfig } from "next";

const nextConfig: NextConfig = {
  distDir: "b",
  outputFileTracingRoot: __dirname,
  allowedDevOrigins: ["http://localhost:3000"],
};

export default nextConfig;
