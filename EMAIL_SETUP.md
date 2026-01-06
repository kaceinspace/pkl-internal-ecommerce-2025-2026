# Setup Email Notification

## Masalah yang Sudah Diperbaiki ✅

1. ✅ **OrderPaidEvent** - Sekarang menerima parameter `$order`
2. ✅ **EventServiceProvider** - Event dan Listener sudah terdaftar
3. ✅ **MidtransNotificationController** - Event dipanggil di `handleSuccess()`

## Cara Menjalankan Email Notification

### 1. Perbaiki Typo di .env
Buka file `.env` dan ubah:
```
MAIL_MAILER=smptp   ❌ (SALAH - ada typo)
```

Menjadi:
```
MAIL_MAILER=smtp    ✅ (BENAR)
```

### 2. Jalankan Queue Worker
Email dikirim via queue (background job), jadi harus jalankan queue worker:

**Windows PowerShell:**
```powershell
php artisan queue:work --tries=3 --timeout=60
```

**Atau jalankan di background terminal terpisah**

### 3. Test Email
Setelah queue worker jalan:
1. Lakukan transaksi pembayaran
2. Cek terminal queue worker, akan muncul log job diproses
3. Email akan dikirim ke Mailtrap (cek inbox di sandbox.smtp.mailtrap.io)

### 4. Check Log (Jika Ada Masalah)
```powershell
Get-Content storage\logs\laravel.log -Tail 50
```

Cari error terkait:
- `SendOrderPaidEmail`
- `OrderPaidEvent`
- `Mail::send`

## Alternative: Email Langsung (Tanpa Queue)

Jika tidak ingin pakai queue, edit file:
`app/Listeners/SendOrderPaidEmail.php`

Hapus `implements ShouldQueue`:
```php
class SendOrderPaidEmail  // ← hapus implements ShouldQueue
{
    // hapus juga: public $tries = 3;
    
    public function handle(OrderPaidEvent $event): void
    {
        Mail::to($event->order->user->email)
            ->send(new OrderPaid($event->order));
    }
}
```

Tapi **TIDAK DISARANKAN** karena akan memperlambat response webhook Midtrans.

## Troubleshooting

### Email Tidak Terkirim?
1. ✅ Queue worker sudah jalan?
2. ✅ Typo MAIL_MAILER sudah diperbaiki?
3. ✅ Credentials Mailtrap benar?
4. ✅ Cek tabel `jobs` di database, ada job yang stuck?

### Cek Job di Database
```sql
SELECT * FROM jobs ORDER BY id DESC LIMIT 10;
```

### Reset Failed Jobs
```powershell
php artisan queue:flush
php artisan queue:failed:flush
```

## Test Manual Event

Untuk test tanpa webhook Midtrans, buat route test:

```php
// routes/web.php (HANYA UNTUK TESTING!)
Route::get('/test-email', function () {
    $order = Order::latest()->first();
    event(new \App\Events\OrderPaidEvent($order));
    return 'Event fired! Check queue worker.';
});
```

Akses: http://localhost:9000/test-email

---

**Sekarang email sudah fix! 📧✅**
