<?php

namespace App\Console\Commands;

use App\Mail\SendProduct;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendMails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:send {email*} {--id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mail';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $emails = $this->argument('email');
        $id = $this->option('id');

        $product = Product::find($id);

        foreach ($emails as  $email){
            Mail::to($email)->send(new SendProduct($product));
        }

    }
}
