#!/bin/bash

# DjokiHub2 Asset Migration Script for Hostinger
# This script moves files from storage/app/public to public/assets/
# to bypass symlink issues.

echo "🚀 Starting Asset Migration..."

# 1. Create target directories if they don't exist
echo "📂 Creating directories..."
mkdir -p public/assets/profile-photos
mkdir -p public/assets/logos/universities
mkdir -p public/assets/logos/banks
mkdir -p public/assets/wiki-covers/

# 2. Copy Profile Photos
if [ -d "storage/app/public/profile-photos" ]; then
    echo "📸 Copying Profile Photos..."
    cp -r storage/app/public/profile-photos/* public/assets/profile-photos/ 2>/dev/null || echo "   (No profile-photos found or empty)"
else
    echo "⚠️  storage/app/public/profile-photos does not exist."
fi

# 3. Copy Logos
if [ -d "storage/app/public/logos/universities" ]; then
    echo "🎓 Copying University Logos..."
    cp -r storage/app/public/logos/universities/* public/assets/logos/universities/ 2>/dev/null || echo "   (No university logos found)"
else
    echo "⚠️  storage/app/public/logos/universities does not exist."
fi

if [ -d "storage/app/public/logos/banks" ]; then
    echo "🏦 Copying Bank Logos..."
    cp -r storage/app/public/logos/banks/* public/assets/logos/banks/ 2>/dev/null || echo "   (No bank logos found)"
else
    echo "⚠️  storage/app/public/logos/banks does not exist."
fi

# 4. Copy Wiki Covers
if [ -d "storage/app/public/wiki-covers" ]; then
    echo "📚 Copying Wiki Covers..."
    cp -r storage/app/public/wiki-covers/* public/assets/wiki-covers/ 2>/dev/null || echo "   (No wiki covers found)"
else
    echo "⚠️  storage/app/public/wiki-covers does not exist."
fi

# 5. Fix permissions
echo "🔒 Fixing permissions..."
chmod -R 755 public/assets

echo "✅ Migration Complete!"
echo "   Please clear your browser cache and refresh."
