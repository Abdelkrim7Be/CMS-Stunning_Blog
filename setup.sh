#!/bin/bash

# CMS Stunning Blog - Setup Script
# This script helps migrate assets from the old structure to the new one

echo "================================================"
echo "   CMS Stunning Blog - Setup Script"
echo "================================================"
echo ""

# Colors for output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Get the script directory
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

echo -e "${YELLOW}Step 1: Moving CSS files...${NC}"
if [ -d "$SCRIPT_DIR/CSS" ]; then
    mv "$SCRIPT_DIR/CSS"/*.css "$SCRIPT_DIR/public/assets/css/" 2>/dev/null && \
    echo -e "${GREEN}✓ CSS files moved${NC}" || \
    echo -e "${RED}✗ No CSS files to move or already moved${NC}"
else
    echo -e "${YELLOW}! CSS directory not found${NC}"
fi

echo ""
echo -e "${YELLOW}Step 2: Moving image files...${NC}"
if [ -d "$SCRIPT_DIR/Images" ]; then
    mv "$SCRIPT_DIR/Images"/* "$SCRIPT_DIR/public/assets/images/" 2>/dev/null && \
    echo -e "${GREEN}✓ Images moved${NC}" || \
    echo -e "${RED}✗ No images to move or already moved${NC}"
else
    echo -e "${YELLOW}! Images directory not found${NC}"
fi

echo ""
echo -e "${YELLOW}Step 3: Moving upload files...${NC}"
if [ -d "$SCRIPT_DIR/Upload" ]; then
    mv "$SCRIPT_DIR/Upload"/* "$SCRIPT_DIR/public/uploads/" 2>/dev/null && \
    echo -e "${GREEN}✓ Uploads moved${NC}" || \
    echo -e "${RED}✗ No uploads to move or already moved${NC}"
else
    echo -e "${YELLOW}! Upload directory not found${NC}"
fi

echo ""
echo -e "${YELLOW}Step 4: Setting permissions...${NC}"
chmod -R 755 "$SCRIPT_DIR/public/uploads"
chmod -R 755 "$SCRIPT_DIR/storage/logs"
echo -e "${GREEN}✓ Permissions set${NC}"

echo ""
echo -e "${YELLOW}Step 5: Checking Composer...${NC}"
if command -v composer &> /dev/null; then
    echo -e "${GREEN}✓ Composer is installed${NC}"
    if [ ! -d "$SCRIPT_DIR/vendor" ]; then
        echo -e "${YELLOW}  Installing dependencies...${NC}"
        cd "$SCRIPT_DIR" && composer install
    fi
else
    echo -e "${RED}✗ Composer not found. Please install Composer first.${NC}"
fi

echo ""
echo "================================================"
echo -e "${GREEN}Setup Complete!${NC}"
echo "================================================"
echo ""
echo "Next Steps:"
echo "1. Configure your database in: config/database.php"
echo "2. Point your web server to: public/"
echo "3. Visit: http://localhost/"
echo "4. Login at: http://localhost/login"
echo ""
echo "Default credentials (from your database):"
echo "Check your 'admins' table for username and password"
echo ""
echo "================================================"
