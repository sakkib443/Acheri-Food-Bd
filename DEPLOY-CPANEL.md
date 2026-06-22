# Acheri Food Bd — cPanel এ ডিপ্লয় গাইড (Step by Step)

এই গাইডটা ধরে নিচ্ছে আপনার cPanel-এ **SSH/Terminal বা Composer নেই** (সাধারণ শেয়ার হোস্টিং) — শুধু **File Manager + phpMyAdmin** দিয়েই পুরো কাজ হবে।
> যদি Terminal থাকে, প্রতিটা ধাপে সহজ বিকল্প `(Terminal থাকলে)` দিয়ে দেওয়া আছে।

---

## ০. শুরুর আগে (একবার চেক)
- cPanel-এ **PHP ভার্সন 8.2 বা তার বেশি** সেট করুন: cPanel → **MultiPHP Manager** → আপনার ডোমেইন সিলেক্ট → PHP **8.2/8.3** সেট করুন।
- PHP **extensions** চালু আছে কিনা দেখুন (সাধারণত থাকে): `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `ctype`, `json`, `fileinfo`, `bcmath`। (cPanel → MultiPHP INI Editor / Select PHP Version → Extensions)

---

## ১. লোকালে আপলোড ফাইল তৈরি

1. লোকালে অ্যাসেট বিল্ড করুন (cPanel-এ Node নেই, তাই আগেই বিল্ড করতে হবে):
   ```
   npm run build
   ```
2. এই প্রজেক্ট ফোল্ডারটা **zip** করুন — কিন্তু নিচের জিনিসগুলো **বাদ** দিন (সাইজ কমাতে):
   - `node_modules/`  ❌
   - `.git/`  ❌
   - `.env`  ❌ (সার্ভারে নতুন বানাবো)
   - `database/database.sqlite`  ❌ (MySQL ব্যবহার হবে)

   **অবশ্যই রাখবেন** ✅: `app/`, `bootstrap/`, `config/`, `database/migrations`, `database/seeders`, `public/` (সহ `public/build` ও `public/images`), `resources/`, `routes/`, `storage/`, **`vendor/`** (গুরুত্বপূর্ণ — Composer নেই বলে), `artisan`, `composer.json`।

   > 💡 সহজ উপায়: File Manager-এ আপলোড করার সময় zip বানিয়ে আপলোড করে সার্ভারে Extract করুন।

---

## ২. cPanel-এ MySQL ডাটাবেস তৈরি

cPanel → **MySQL® Databases**:
1. **Create New Database**: যেমন `acheri` → তৈরি হবে `cpanelusername_acheri`।
2. **Add New User**: একটা ইউজার ও শক্তিশালী পাসওয়ার্ড — `cpanelusername_acheri`।
3. **Add User To Database** → ইউজারকে ডাটাবেসে যোগ করুন → **ALL PRIVILEGES** দিন।
4. তিনটা মান টুকে রাখুন: **DB name, DB user, DB password** (পরে `.env`-এ লাগবে)।

---

## ৩. ফাইল আপলোড ও ডকুমেন্ট রুট (গুরুত্বপূর্ণ)

Laravel-এর সব কিছু `public_html`-এ রাখলে নিরাপদ নয়। নিচের **নিরাপদ পদ্ধতি** ব্যবহার করুন:

### পদ্ধতি A (রিকমেন্ডেড — নিরাপদ)
1. cPanel **File Manager**-এ `public_html`-এর **বাইরে** (অর্থাৎ home ডিরেক্টরিতে) একটা ফোল্ডার বানান: `acheri`।
   - পথ হবে: `/home/cpanelusername/acheri`
2. আপনার zip-টা ওই `acheri` ফোল্ডারে আপলোড করে **Extract** করুন। এখন `acheri/app`, `acheri/public`, `acheri/vendor` ইত্যাদি থাকবে।
3. `acheri/public` ফোল্ডারের **ভেতরের সব ফাইল** (`index.php`, `.htaccess`, `build/`, `images/`, `favicon` ইত্যাদি) **কপি/মুভ করুন `public_html`-এ**।
4. এখন `public_html/index.php` ফাইলটা **Edit** করুন — দুটো লাইনের পথ ঠিক করুন:

   খুঁজুন:
   ```php
   require __DIR__.'/../vendor/autoload.php';
   $app = require_once __DIR__.'/../bootstrap/app.php';
   ```
   বদলে দিন:
   ```php
   require __DIR__.'/../acheri/vendor/autoload.php';
   $app = require_once __DIR__.'/../acheri/bootstrap/app.php';
   ```
   আর উপরের maintenance লাইনটাও (থাকলে):
   ```php
   if (file_exists($maintenance = __DIR__.'/../acheri/storage/framework/maintenance.php')) {
   ```
   > মানে শুধু `/../` কে `/../acheri/` করে দিচ্ছেন।

### পদ্ধতি B (সবচেয়ে সহজ, কম নিরাপদ)
- পুরো প্রজেক্টটা সরাসরি `public_html`-এ extract করুন।
- `public_html`-এ একটা `.htaccess` বানান:
  ```
  RewriteEngine On
  RewriteRule ^(.*)$ public/$1 [L]
  ```
- (এই পদ্ধতিতে অ্যাপ ফাইল ওয়েব রুটের নিচে থাকে — ছোট সাইটের জন্য চলে, কিন্তু পদ্ধতি A বেশি নিরাপদ।)

---

## ৪. `.env` ফাইল তৈরি (সার্ভারে)

1. প্রজেক্টে দেওয়া **`.env.production.example`** ফাইলটা কপি করে নাম দিন **`.env`** (পদ্ধতি A হলে `acheri/.env`, পদ্ধতি B হলে `public_html/.env`)।
2. ভেতরের মানগুলো পূরণ করুন:
   - `APP_URL=https://আপনার-ডোমেইন.com`
   - `DB_DATABASE / DB_USERNAME / DB_PASSWORD` → ধাপ ২-এর মান
   - **`APP_KEY`** → আপনার লোকাল `.env` থেকে `APP_KEY=base64:...` লাইনটা **হুবহু কপি** করে বসান।
     - *(Terminal থাকলে:* `php artisan key:generate` *চালালেই হবে।)*

---

## ৫. ডাটাবেস টেবিল + ডেমো ডেটা তৈরি (migrate + seed)

**Terminal না থাকলে — ওয়েব ইনস্টলার দিয়ে (সহজ):**
1. `.env`-এ সাময়িকভাবে সেট করুন: `ALLOW_WEB_SETUP=true`
2. ব্রাউজারে যান: `https://আপনার-ডোমেইন.com/__setup`
   - এটা সব টেবিল তৈরি করবে + ক্যাটাগরি/প্রোডাক্ট/অ্যাডমিন seed করবে। আউটপুটে `DONE` দেখাবে।
3. কাজ শেষে অবশ্যই `.env`-এ আবার সেট করুন: `ALLOW_WEB_SETUP=false` ✅ (নিরাপত্তার জন্য)

**Terminal থাকলে (আরও পরিষ্কার):**
```
php artisan migrate --force
php artisan db:seed --force
```

---

## ৬. ফোল্ডার পারমিশন

File Manager-এ এই দুটো ফোল্ডার **লেখার যোগ্য (writable)** হতে হবে — Permissions **755** (না হলে **775**):
- `storage/` (সহ ভেতরের সব — Recurse করুন)
- `bootstrap/cache/`

> ছবি আপলোড (`public/images/products`, `public/images/categories`) সরাসরি public-এ যায়, তাই **`storage:link` লাগবে না** — একটা ঝামেলা কম।

---

## ৭. টেস্ট করুন
- 🏠 সাইট: `https://আপনার-ডোমেইন.com`
- 🛍️ প্রোডাক্ট: `/products`
- 🔐 অ্যাডমিন: `/admin/login`
  - Email: **admin@gmail.com** · Password: **admin@gmail.com**

সব ঠিক থাকলে — অর্ডার দিয়ে দেখুন, admin → Orders-এ আসবে, আর WhatsApp কনফার্ম বাটন কাজ করবে।

---

## ৮. ডিপ্লয়ের পর নিরাপত্তা (অবশ্যই)
- [ ] `.env`-এ `ALLOW_WEB_SETUP=false`
- [ ] `.env`-এ `APP_DEBUG=false` ও `APP_ENV=production`
- [ ] অ্যাডমিন লগইন করে **পাসওয়ার্ড বদলান** (এখন ডিফল্ট দেওয়া আছে)
- [ ] `https://...` (SSL) চালু আছে কিনা দেখুন (cPanel → SSL/TLS Status → AutoSSL)

---

## ৯. পরে আপডেট করতে (নতুন কাজ আপলোড)
1. লোকালে `npm run build` করুন।
2. শুধু বদলানো ফাইল/ফোল্ডার আপলোড করুন (সাধারণত `app/`, `resources/`, `routes/`, `config/`, `public/build/`, নতুন `database/migrations/`)।
3. নতুন migration থাকলে: `ALLOW_WEB_SETUP=true` → `/__setup` → আবার `false`। (অথবা Terminal-এ `php artisan migrate --force`)
4. কিছু না দেখালে cache পরিষ্কার করুন (Terminal থাকলে): `php artisan config:clear && php artisan view:clear`

---

### সমস্যা হলে দ্রুত চেক
- **500 error** → `.env`-এ `APP_DEBUG=true` দিয়ে আবার দেখুন কী error; অথবা `storage/logs/laravel.log` দেখুন। PHP ভার্সন 8.2+ কিনা নিশ্চিত করুন।
- **CSS/ডিজাইন আসছে না** → `public/build` ফোল্ডার আপলোড হয়েছে কিনা, আর `APP_URL` ঠিক আছে কিনা দেখুন।
- **DB error** → `.env`-এর DB নাম/ইউজার/পাসওয়ার্ড আর `DB_HOST=127.0.0.1` ঠিক আছে কিনা দেখুন।
