#!/bin/bash

# Fix Storage Migration Script for Hostinger
# This script copies assets from the default Laravel storage path to the public assets path.
# It automatically detects if it's running on a Hostinger-like structure (with public_html).

echo "🚀 Starting Asset Migration..."

# Determine Target Directory
# On Hostinger, the web root is often ../public_html relative to the laravel project
if [ -d "../public_html" ]; then
    echo "🌍 Detected Hostinger/cPanel structure. Target is ../public_html/assets"
    TARGET_DIR="../public_html/assets"
else
    echo "💻 Detected Local/Standard structure. Target is public/assets"
    TARGET_DIR="public/assets"
fi

# Create target directories
echo "📂 Creating directories at $TARGET_DIR..."
mkdir -p "$TARGET_DIR/profile-photos"
mkdir -p "$TARGET_DIR/logos/universities"
mkdir -p "$TARGET_DIR/logos/banks"
mkdir -p "$TARGET_DIR/wiki-covers"

# 1. Profile Photos
if [ -d "storage/app/public/profile-photos" ]; then
    echo "📸 Migrating Profile Photos..."
    cp -r storage/app/public/profile-photos/* "$TARGET_DIR/profile-photos/" 2>/dev/null || echo "   (Empty or no files found)"
else
    echo "ℹ️  No storage/profile-photos found."
fi

# 2. University/Bank Logos
if [ -d "storage/app/public/logos" ]; then
    echo "🏦 Migrating Logos..."
    cp -r storage/app/public/logos/* "$TARGET_DIR/logos/" 2>/dev/null || echo "   (Empty or no files found)"
else
    echo "ℹ️  No storage/logos found."
fi

# 3. Wiki Covers
if [ -d "storage/app/public/wiki-covers" ]; then
    echo "📚 Migrating Wiki Covers..."
    cp -r storage/app/public/wiki-covers/* "$TARGET_DIR/wiki-covers/" 2>/dev/null || echo "   (Empty or no files found)"
else
    echo "ℹ️  No storage/wiki-covers found."
fi

echo "--------------------------------------------------------"
echo "🎉 Migration Complete!"
echo "✅ Assets have been copied to: $TARGET_DIR"
echo "👉 HOSTINGER USERS: Please ensure '$TARGET_DIR' has 755 permissions."
echo "--------------------------------------------------------"
