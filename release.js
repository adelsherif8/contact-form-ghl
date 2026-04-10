#!/usr/bin/env node
/**
 * One-command release script for contact-form-ghl WordPress plugin.
 *
 * Usage:
 *   npm run release          → bumps patch  (1.2.0 → 1.2.1)
 *   npm run release minor    → bumps minor  (1.2.0 → 1.3.0)
 *   npm run release major    → bumps major  (1.2.0 → 2.0.0)
 *   npm run release 1.5.0    → sets exact version
 *
 * What it does:
 *   1. Reads current version from contact-form-ghl.php
 *   2. Calculates next version
 *   3. Updates Version: line in plugin file
 *   4. Updates package.json version
 *   5. git commit + tag + push
 *   6. GitHub release is created automatically by GitHub Actions
 */

const fs   = require('fs');
const path = require('path');
const { execSync } = require('child_process');

const PLUGIN_FILE = path.join(__dirname, 'contact-form-ghl.php');
const PKG_FILE    = path.join(__dirname, 'package.json');

// ── helpers ────────────────────────────────────────────────────

function run(cmd, silent = false) {
  if (!silent) console.log(`  → ${cmd}`);
  return execSync(cmd, { cwd: __dirname, encoding: 'utf8', stdio: silent ? 'pipe' : 'inherit' });
}

function bump(version, type) {
  const parts = version.split('.').map(Number);
  if (type === 'major') { parts[0]++; parts[1] = 0; parts[2] = 0; }
  else if (type === 'minor') { parts[0]; parts[1]++; parts[2] = 0; }
  else { parts[2]++; } // patch
  return parts.join('.');
}

// ── read current version from plugin header ────────────────────

const pluginContent = fs.readFileSync(PLUGIN_FILE, 'utf8');
const versionMatch  = pluginContent.match(/^\s*\*\s*Version:\s*([\d.]+)/m);
if (!versionMatch) {
  console.error('ERROR: Could not find "Version:" in plugin file header.');
  process.exit(1);
}
const currentVersion = versionMatch[1];

// ── determine new version ──────────────────────────────────────

const arg = process.argv[2] || 'patch';
let newVersion;

if (/^\d+\.\d+\.\d+$/.test(arg)) {
  newVersion = arg; // exact version provided
} else if (['major', 'minor', 'patch'].includes(arg)) {
  newVersion = bump(currentVersion, arg);
} else {
  console.error(`ERROR: Invalid argument "${arg}". Use: major | minor | patch | x.y.z`);
  process.exit(1);
}

console.log(`\n🚀 Releasing: v${currentVersion}  →  v${newVersion}\n`);

// ── update plugin file ─────────────────────────────────────────

const updatedPlugin = pluginContent.replace(
  /^(\s*\*\s*Version:\s*)[\d.]+/m,
  `$1${newVersion}`
);
fs.writeFileSync(PLUGIN_FILE, updatedPlugin, 'utf8');
console.log(`✅ Updated Version in contact-form-ghl.php → ${newVersion}`);

// ── update package.json ────────────────────────────────────────

const pkg = JSON.parse(fs.readFileSync(PKG_FILE, 'utf8'));
pkg.version = newVersion;
fs.writeFileSync(PKG_FILE, JSON.stringify(pkg, null, 2) + '\n', 'utf8');
console.log(`✅ Updated package.json → ${newVersion}`);

// ── git commit, tag, push ──────────────────────────────────────

console.log('\n📦 Committing and tagging...\n');
run(`git add contact-form-ghl.php package.json`);
run(`git commit -m "Release v${newVersion}"`);
run(`git tag v${newVersion}`);
run(`git push origin main`);
run(`git push origin v${newVersion}`);

console.log(`\n✅ Done! v${newVersion} pushed to GitHub.`);
console.log(`   GitHub Actions will now build the release ZIP automatically.`);
console.log(`   Watch it at: https://github.com/adelsherif8/contact-form-ghl/actions\n`);
