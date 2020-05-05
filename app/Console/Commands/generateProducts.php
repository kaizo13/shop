<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use App\Models\Valoration;

use Illuminate\Console\Command;

class generateProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generateProducts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generates random products';

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
     *
     * @return mixed
     */
    public function handle()
    {

        $user1=new User;
        $user1->email="alexcampo13@outlook.com";
        $user1->password=bcrypt('123');
        $user1->role="CUSTOMER";
       

        $customer1=new Customer;
        $customer1->name="Alejandro Campo";
        $customer1->dni="25204116A";
        $customer1->email="alexcampo13@outlook.com";
        $customer1->phone="657662751";
        $customer1->address="Elvira de Hidalgo 9";
        $customer1->postalCode="50004";

        $user1->save();
        $customer1->idUser=$user1->id;
        $customer1->save();

        $cart1=new Cart;
        $cart1->name="Carro 1";
        $cart1->idCustomer=$customer1->id;
        $cart1->save();

        $user2=new User;
        $user2->email="robertootal@outlook.com";
        $user2->password=bcrypt('123');
        $user2->role="CUSTOMER";
       

        $customer2=new Customer;
        $customer2->name="Roberto Otal";
        $customer2->dni="25204563L";
        $customer2->email="robertootal@outlook.com";
        $customer2->phone="666";
        $customer2->address="Elvira de Hidalgo 7";
        $customer2->postalCode="50004";

        $user2->save();
        $customer2->idUser=$user2->id;
        $customer2->save();

        $cart2=new Cart;
        $cart2->name="Carro 1";
        $cart2->idCustomer=$customer2->id;
        $cart2->save();

        $articles=array('Camiseta','Pantalón','Polo','Gorra','Zapatos','Bolso','Americana');
        $brands=array('Armani','Gucci','Hugo Boss','Channel','Zara','Cortefield','Mango');

        foreach($articles as $article){
            $a=new Article;
            $a->name=$article;
            $a->save();
        }

        foreach($brands as $brand){
            $b=new Brand;
            $b->name=$brand;
            $b->save();
        }

       

        $articles=Article::all();
        $brands=Brand::all();
        $customers=Customer::all();

        for($i=0;$i<25;$i++){
            $product=new Product;
            $article=Article::where('id',random_int(1,count($articles)))->first();
            $brand=Brand::where('id',random_int(1,count($articles)))->first();
            $product->idArticle=$article->id;
            $product->idBrand=$brand->id;
            $product->description=$article->name . " de " . $brand->name;
            $product->price=rand(15,65);
            $product->save();

            foreach($customers as $customer){
                $valoration=new Valoration;
                $valoration->idProduct=$product->id;
                $valoration->idCustomer=$customer->id;
                $valoration->valoration=random_int(1,5);
                $valoration->save();
            }
            
        }
    }
}
