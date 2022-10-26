<?php

namespace App;

class Catalog 
{
    public $itemServices = [
        [
            'itemId' => '1',
            'warranty' => '1 year', 
            'warrantyCost' => '0', 
            'delivery' => '1 week', 
            'deliveryCost' => '50'
        ],
        [
            'itemId' => '2',
            'warranty' => '2 year', 
            'warrantyCost' => '100', 
            'delivery' => '1 week', 
            'deliveryCost' => '38' 
        ],
        [
            'itemId' => '3',
            'warranty' => '1 year', 
            'warrantyCost' => '0', 
            'delivery' => '10 days', 
            'deliveryCost' => '60'
        ],
        [
            'itemId' => '4',
            'warranty' => '1 year', 
            'warrantyCost' => '0', 
            'delivery' => '8 days', 
            'deliveryCost' => '30', 
            'setupCost' => '10'
        ],
        [
            'itemId' => '5',
            'warranty' => '1 year', 
            'warrantyCost' => '0', 
            'delivery' => '1 week', 
            'deliveryCost' => '30', 
            'setupCost' => '20'
        ],
        [
            'itemId' => '6',
            'warranty' => '1 year', 
            'warrantyCost' => '0', 
            'delivery' => '9 days', 
            'deliveryCost' => '30', 
            'setupCost' => '20'
        ],
        [
            'itemId' => '7',
            'warranty' => '1 year', 
            'warrantyCost' => '20', 
            'delivery' => '1 week', 
            'deliveryCost' => '20', 
            'setupCost' => '30'
        ],
        [
            'itemId' => '8',
            'warranty' => '1 year', 
            'warrantyCost' => '0', 
            'delivery' => '10 days', 
            'deliveryCost' => '10', 
            'setupCost' => '10'
        ],
        [
            'itemId' => '9',
            'warranty' => '1 year', 
            'warrantyCost' => '0', 
            'delivery' => '8 days', 
            'deliveryCost' => '15', 
            'setupCost' => '15'
        ],
        [
            'itemId' => '10',
            'warranty' => '3 year', 
            'warrantyCost' => '80', 
            'delivery' => '15 days',
            'deliveryCost' => '50', 
            'setupCost' => '40'
        ],
        [
            'itemId' => '11',
            'warranty' => '3 year', 
            'warrantyCost' => '150', 
            'delivery' => '15 days', 
            'deliveryCost' => '70', 
            'setupCost' => '50'
        ],
        [
            'itemId' => '12',
            'warranty' => '2 year', 
            'warrantyCost' => '0', 
            'delivery' => '15 days', 
            'deliveryCost' => '50', 
            'setupCost' => '40'
        ]
    ];

    public $itemCatalog = [
        [
            'id' => '1',
            'item' => 'Телевизор Horizont 32LE7051D', 
            'manufacturer' => 'Horizont', 
            'price' => '500', 
            'image' => 'Телевизор Horizont 32LE7051D.jpeg', 
            'created' => '2022'
        ],
        [   
            'id' => '2',
            'item' => 'Телевизор LG 32LM576BPLD', 
            'manufacturer' => 'LG', 
            'price' => '950', 
            'image' => 'Телевизор LG 32LM576BPLD.jpeg', 
            'created' => '2021'
        ],
        [
            'id' => '3',
            'item' => 'Телевизор Philips 43PFS5505(60)', 
            'manufacturer' => 'Philips', 
            'price' => '995', 
            'image' => 'Телевизор Philips 43PFS5505.jpeg', 
            'created' => '2020'
        ],
        [
            'id' => '4',
            'item' => 'Ноутбук HP 250 G8 (2X7T8EA)', 
            'manufacturer' => 'HP', 
            'price' => '999', 
            'image' => 'Ноутбук HP 250 G8 (2X7T8EA).jpg', 
            'created' => '2020'
        ],
        [
            'id' => '5',
            'item' => 'Ноутбук Lenovo IdeaPad L3 15ITL6', 
            'manufacturer' => 'Lenovo', 
            'price' => '1399', 
            'image' => 'Ноутбук Lenovo IdeaPad L3 15ITL6.jpg', 
            'created' => '2021'
        ],
        [
            'id' => '6',
            'item' => 'Ноутбук Acer Aspire 3 A315-34-P7TD', 
            'manufacturer' => 'Acer', 
            'price' => '1199', 
            'image' => 'Ноутбук Acer Aspire 3 A315-34-P7TD.jpg', 
            'created' => '2020'
        ],
        [
            'id' => '7',
            'item' => 'Смартфон Apple iPhone 13 128GB', 
            'manufacturer' => 'Apple', 
            'price' => '3099', 
            'image' => 'Смартфон Apple iPhone 13 128GB.jpg', 
            'created' => '2021'
        ],
        [
            'id' => '8',
            'item' => 'Смартфон Xiaomi Redmi Note 11 4GB(64GB)', 
            'manufacturer' => 'Xiaomi', 
            'price' => '810', 
            'image' => 'Смартфон Xiaomi Redmi Note 11 4GB.jpg', 
            'created' => '2022'
        ],
        [
            'id' => '9',
            'item' => 'Смартфон Samsung Galaxy A23 128GB', 
            'manufacturer' => 'Samsung', 
            'price' => '899', 
            'image' => 'Смартфон Samsung Galaxy A23 128GB.jpg', 
            'created' => '2022'
        ],
        [
            'id' => '10',
            'item' => 'Холодильник с морозильником ATLANT ХМ 4208-000', 
            'manufacturer' => 'ATLANT', 
            'price' => '900', 
            'image' => 'Холодильник с морозильником ATLANT ХМ 4208-000.jpg', 
            'created' => '2017'
        ],
        [
            'id' => '11',
            'item' => 'Холодильник с морозильником LG DoorCooling GA-B509MMQM', 
            'manufacturer' => 'LG', 
            'price' => '2499', 
            'image' => 'Холодильник с морозильником LG DoorCooling GA-B509MMQM.jpg', 
            'created' => '2021'
        ],
        [
            'id' => '12',
            'item' => 'Холодильник с морозильником Beko CNMV5335E20VS', 
            'manufacturer' => 'Beko', 
            'price' => '1579', 
            'image' => 'Холодильник с морозильником Beko CNMV5335E20VS.jpg', 
            'created' => '2020'
        ]
    ];
}