#!/bin/bash

# Role Management Setup Script
# This script sets up the role management system for the CMS

echo "========================================="
echo "  CMS Role Management Setup"
echo "========================================="
echo ""

# Colors for output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Get database credentials
echo -e "${YELLOW}Please enter your database credentials:${NC}"
read -p "Database host (default: localhost): " DB_HOST
DB_HOST=${DB_HOST:-localhost}

read -p "Database name: " DB_NAME
if [ -z "$DB_NAME" ]; then
    echo -e "${RED}Database name is required!${NC}"
    exit 1
fi

read -p "Database user: " DB_USER
if [ -z "$DB_USER" ]; then
    echo -e "${RED}Database user is required!${NC}"
    exit 1
fi

read -sp "Database password: " DB_PASS
echo ""

# Test database connection
echo -e "\n${YELLOW}Testing database connection...${NC}"
mysql -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" -e "SELECT 1;" > /dev/null 2>&1

if [ $? -ne 0 ]; then
    echo -e "${RED}Failed to connect to database. Please check your credentials.${NC}"
    exit 1
fi

echo -e "${GREEN}✓ Database connection successful${NC}"

# Run migration
echo -e "\n${YELLOW}Running role management migration...${NC}"
mysql -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" < database/migrations/add_roles.sql

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Migration completed successfully${NC}"
else
    echo -e "${RED}✗ Migration failed${NC}"
    exit 1
fi

# Ask for super admin setup
echo -e "\n${YELLOW}Do you want to set up a super admin user?${NC}"
read -p "(y/n): " SETUP_ADMIN

if [ "$SETUP_ADMIN" = "y" ] || [ "$SETUP_ADMIN" = "Y" ]; then
    echo -e "\n${YELLOW}Available users:${NC}"
    mysql -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" -e "SELECT id, username, aname, role FROM admins;"
    
    echo ""
    read -p "Enter user ID to make super admin: " ADMIN_ID
    
    if [ ! -z "$ADMIN_ID" ]; then
        mysql -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" -e "UPDATE admins SET role = 'super_admin' WHERE id = $ADMIN_ID;"
        
        if [ $? -eq 0 ]; then
            echo -e "${GREEN}✓ User #$ADMIN_ID has been set as super admin${NC}"
        else
            echo -e "${RED}✗ Failed to update user role${NC}"
        fi
    fi
fi

# Summary
echo ""
echo "========================================="
echo -e "${GREEN}  Setup Complete!${NC}"
echo "========================================="
echo ""
echo "Next steps:"
echo "1. Review the ROLE_MANAGEMENT.md documentation"
echo "2. Login with your super admin account"
echo "3. Create additional users with appropriate roles"
echo "4. Test the permission system"
echo ""
echo -e "${YELLOW}Documentation:${NC} ROLE_MANAGEMENT.md"
echo -e "${YELLOW}Role Class:${NC} src/Core/Role.php"
echo -e "${YELLOW}Session Class:${NC} src/Core/Session.php"
echo ""
echo "Thank you for using the CMS Role Management System!"
echo ""
