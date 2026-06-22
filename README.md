# EASTCSO STUDENT PORTAL — Maelekezo ya Kufunga (Setup)

## Muundo wa Faili
```
eastcso/
 ├─ index.html          → Ukurasa wa Nyumbani (Hero carousel + matangazo)
 ├─ about.html           → Kuhusu EASTC na EASTCSO
 ├─ leaders.html         → Chati ya uongozi + orodha ya viongozi (kutoka database)
 ├─ contact.html         → Fomu ya mawasiliano
 ├─ login.html           → Kuingia kwa Admin
 ├─ dashboard.php        → Dashboard ya Admin (CRUD - inalindwa na login)
 ├─ css/style.css        → CSS yote ya tovuti
 ├─ js/main.js           → JavaScript yote (menu, carousel, AJAX)
 ├─ php/                 → Faili zote za PHP (backend)
 │   ├─ config.php
 │   ├─ login.php
 │   ├─ logout.php
 │   ├─ auth_check.php
 │   ├─ get_announcements.php
 │   ├─ announcements_crud.php
 │   ├─ leaders_crud.php
 │   ├─ contact_handler.php
 │   └─ generate_password.php
 ├─ images/              → Picha (logo, makundi, chati ya uongozi)
 └─ sql/database.sql     → Schema ya database
```

## Hatua za Kufunga (kwa XAMPP / WAMP / Laragon)

1. **Weka project kwenye server ya PHP**
   - Nakili folder nzima `eastcso` kwenye `htdocs` (XAMPP) au `www` (WAMP/Laragon).

2. **Anzisha Database**
   - Fungua phpMyAdmin → Import → chagua faili `sql/database.sql` → Go.
   - Hii itaunda database `eastcso_portal` na majedwali: `admins`, `announcements`, `leaders`, `contact_messages`.

3. **Tengeneza Password Sahihi ya Admin**
   - Fungua kwenye browser: `http://localhost/eastcso/php/generate_password.php`
   - Nakili "hash" inayoonekana.
   - Kwenye phpMyAdmin, fungua jedwali `admins`, hariri safu ya `password` ya admin wako, bandika hash hiyo.
   - (Au futa hash ya mfano kwenye database.sql na uweke hii mpya kabla ya Import.)
   - Username chaguo-msingi: `admin` | Password chaguo-msingi (kabla ya hash mpya): `eastcso2026`

4. **Hariri Mipangilio ya Database (kama inahitajika)**
   - Fungua `php/config.php` na badilisha `DB_USER`, `DB_PASS`, `DB_NAME` kulingana na server yako.

5. **Fungua Tovuti**
   - `http://localhost/eastcso/index.html`

6. **Ingia kama Admin**
   - `http://localhost/eastcso/login.html`
   - Tumia username/password uliyoweka. Utapelekwa kwenye `dashboard.php` ambapo unaweza:
     - Kuongeza / Kuhariri / Kufuta **Matangazo** (yanaonekana home page)
     - Kuongeza / Kuhariri / Kufuta **Viongozi** (wanaonekana leaders.html)

## Kubadilisha Majina ya Viongozi
- Rahisi zaidi: ingia Dashboard → tab "Viongozi" → hariri/ongeza.
- Au moja kwa moja kwenye `sql/database.sql` kabla ya kuingiza database.

## Kupeleka Mtandaoni (Deployment)
- Tumia hosting inayotumia PHP + MySQL (mfano: InfinityFree, 000webhost, au hosting yenye cPanel).
- Pakia faili zote, ingiza `sql/database.sql` kwenye phpMyAdmin ya hosting, badilisha `php/config.php`
  kwa taarifa za database ya hosting.

## Vidokezo vya Menu (Desktop vs Simu)
- **Desktop**: menu inaonekana ya mlalo (horizontal) katikati ya header, na kitufe cha "Ingia" kuliani.
- **Simu**: menu inafichwa nyuma ya "hamburger" (☰) na inatokea kama dirisha la kuteleza kutoka KULIANI
  (tofauti na desktop ambayo iko juu, ya mlalo) — hivyo nafasi zake si sawa kimakusudi.
- Kila link ina `target="_self"` kuhakikisha inafungua kwenye dirisha lile lile (hakuna tab mpya).
