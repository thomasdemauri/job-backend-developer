<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Product;
use Illuminate\Database\QueryException;

class ImportProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:import {--id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products from fakestoreapi';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $idImport = $this->option('id');

        if ($idImport) {

            $url = "https://fakestoreapi.com/products/{$idImport}";
            $response = Http::acceptJson()->get($url)->json();

            $product = [
                'name' => $response['title'],
                'price' => $response['price'],
                'description' => $response['description'],
                'category' => $response['category'],
                'image_url' => $response['image']
            ];

            $product = Product::create($product);

            if ($product->id != null) {
                $this->info('Product imported successfully!');
            }

        }

        if (!$idImport) {
            
            $url = "https://fakestoreapi.com/products";
            $response = Http::acceptJson()->get($url)->json();
            $products = [];

            $bar = $this->output->createProgressBar(count($response));
            $bar->start();

            foreach ($response as $product) {
                $products[] = [
                    'name' => $product['title'],
                    'price' => $product['price'],
                    'description' => $product['description'],
                    'category' => $product['category'],
                    'image_url' => $product['image']
                ];
                $bar->advance();
            }

            try {

                foreach ($products as $product) {

                    Product::create($product);

                    $bar->advance();
                }

                $bar->finish();
                $this->newLine();
                $this->info('All products imported successfully!');

            } catch (QueryException $e) {
                $bar->finish();
                $this->newLine();
                $this->error("Products import failed. Error: {$e}");
                $this->newLine();
                return 1;
            }

        }

        return 0;
    }
}
