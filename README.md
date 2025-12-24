# MapleCart - Multi-tenant E-commerce

## 📌 About
A learning project built with Laravel to study multi-tenant e-commerce architecture.  
**Status:** In development (learning).

## 🚀 Current Features
- ✅ Multiple stores system
- ✅ Simple and variable products
- ✅ Dynamic attributes (color, size, etc.)
- ✅ Seeders with test data

## 🛠️ Technologies
- PHP 8.4 + Laravel 12
- MySQL
- Tailwind CSS

## 📦 Quick Setup
```bash
git clone https://github.com/rauldiamantino/maplecart.git
cd maplecart
composer install
npm install

cp .env.example .env
php artisan key:generate
php artisan migrate --seed

npm run dev
php artisan serve
```

## 📁 Project Structure
```
Models/
├── Store          
├── Product        
├── ProductVariation
├── Attribute      
└── AttributeValue
```

## 🎯 Learning Goals
- Practice Laravel (Eloquent, Migrations)
- Understand complex database relationships
- Build real e-commerce features step by step

## 📝 Note
This is a **learning project**.  
I'm implementing features gradually as I learn.

---

*Last update: December 2025*

**"Code in progress, knowledge in construction."**
