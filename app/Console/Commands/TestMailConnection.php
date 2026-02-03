<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Swift_SmtpTransport;

class TestMailConnection extends Command
{
    protected $signature = 'mail:test';
    protected $description = 'Prueba la conexión SMTP usando la configuración del .env';

    public function handle()
    {
        $host = config('mail.mailers.smtp.host');
        $port = config('mail.mailers.smtp.port');
        $username = config('mail.mailers.smtp.username');
        $password = config('mail.mailers.smtp.password');
        $encryption = config('mail.mailers.smtp.encryption');

        $this->info("Probando conexión SMTP...");
        $this->line("Host: $host");
        $this->line("Puerto: $port");
        $this->line("Usuario: $username");
        $this->line("Encriptación: $encryption");
        $this->line('');

        try {
            $transport = new Swift_SmtpTransport($host, $port, $encryption);
            $transport->setUsername($username);
            $transport->setPassword($password);

            $transport->start();

            $this->info('✅ Conexión SMTP exitosa. Las credenciales son válidas.');
        } catch (\Exception $e) {
            $this->error('❌ Error al conectar:');
            $this->error($e->getMessage());
        }
    }
}
