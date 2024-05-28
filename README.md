<p align="center">
    <a href="https://laravel.com" target="_blank">
        <img src="https://oauth.net/images/oauth-2-sm.png"  alt="Laravel Logo">
    </a>
</p>

# OAuth asoslari Laravel bilan

OAuth2 - bu resursga ruxsat berish jarayonlari standarti. Protokol bilan qisqacha tanishamiz va Laravel bilan integratsiya qilamiz. 

## Boshlang'ich talablar
Jarayonni tezlashtirish uchun barcha kerakli paketlar o'rnatilgan.

### O'rnatilgan paketlar:
- [Socialite](https://laravel.com/docs/11.x/socialite) - asosiy OAuth paketi
- [Breeze](https://laravel.com/docs/11.x/starter-kits#laravel-breeze) - minimal autentifikatsiya va boshlang'ich sahifalar paketi
- [Telescope](https://laravel.com/docs/11.x/telescope) - ish jarayonida qulaylik uchun yordamchi (majburiy emas)

## Sozlash bo'yicha yo'riqnoma
### Servisni sozlash
<code>config/services.php</code> ichida github uchun ma'lumotlarni kiritamiz

```php
'github' => [
    'client_id'     => env('GITHUB_CLIENT_ID'),
    'client_secret' => env('GITHUB_CLIENT_SECRET'),
    'redirect'      => 'https://example.com/callback-url',
],
```
#### GitHubdan client_id va client_secret olish

1. Ushbu [havola](https://github.com/settings/developers) orqali githubnin oauth tokenlari bo'limiga o'tamiz
2. <code>New OAuth app</code> tugmasi orqali o'tamiz va barcha majburiy inputlarni to'ldirib yangi app yaratamiz
3. Appni ichiga kirib <code>Client ID</code> olamiz
4. <code>Generate a new client secret</code> tugmasi orqali <code>Client secret</code> olamiz

### Routlarni sozlash

```php
use Laravel\Socialite\Facades\Socialite;

Route::get('/auth/redirect', function () {
    return Socialite::driver('github')->redirect();
});
 
Route::get('/auth/callback', function () {
    $user = Socialite::driver('github')->user();
});
```

> ### MUHIM ESLATMA!
> 
> <code>auth.php</code> dagi callback route va <code>services.php</code> dagi redirect urllari bir xil bo'lishi kerak!

### GitHub orqali kirish tugmasini yaratish

<code>reserouces/views/components</code> papkasida <code>social-links.blade.php</code> fayl yaratamiz va tugmani "yozamiz"

```php
<div class="mt-4 space-y-2">
    <a class="inline-flex w-full items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition duration-150 ease-in-out hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25"
       href="{{ url('/auth/redirect') }}">
        GitHub
    </a>
</div>
```

> Yodda tuting!
> 
> ```php 
> url('/auth/redirect') // auth.php dagi redirect url
> ```

### GitHub orqali kirish tugmasini ko'rsatish
<code>resources/views/auth/login.blade.php</code> faylimizda o'zimizga kerakli bo'lgan joyga tugmani (komponentni) qo'shamiz
```html
<x-social-links/>
```

## Keyingi bosqich - Live Coding
