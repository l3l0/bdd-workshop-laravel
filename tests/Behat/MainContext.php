<?php

declare(strict_types=1);

namespace Tests\Behat;

use App\Models\Product;
use App\Service\CreateProduct;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Tester\Exception\PendingException;
use PHPUnit\Framework\Assert;
use Ramsey\Uuid\Uuid;
use Soulcodex\Behat\Addon\Context;

class MainContext extends Context
{
    private ?string $lastResponse = null;
    private CreateProduct $createProduct;

    public function __construct(CreateProduct $createProduct)
    {
        $this->createProduct = $createProduct;
    }

    /**
     * @BeforeScenario
     */
    public function clearDatabase(): void
    {
        Product::query()->delete();
    }

    /**
     * @When chce utworzyć nowy produkt leasingowy z takimi danymi:
     */
    public function chceUtworzycNowyProduktLeasingowyZTakimiDanymi(TableNode $table)
    {
        $mapTypes = [
            'LpsMax' => 1,
            'PasMax' => 2,
            'None' => 0
        ];
        foreach ($table as $row) {
            $array = [
                'product_type' => $mapTypes[$row['type']],
                'name' => $row['Nazwa produktu'],
                'is_collective' => $row['zbiorczy'] === 'tak',
                'is_leasing_product' => $row['czy_leasingowy'] === 'tak',
                'rp_ratings' => [
                    'a' => $row['rating a'],
                    'b' => $row['rating b'],
                    'c' => $row['rating c'],
                    's' => $row['rating s'],
                ]
            ];

            /**
             * @var \Soulcodex\Behat\Driver\KernelDriver $driver
             */
            $driver = $this->getSession()->getDriver();

            $driver->getClient()->request('POST', '/create_product', [], [], [
                'CONTENT_TYPE' => 'application/json',
            ], json_encode($array, JSON_THROW_ON_ERROR));

            $response = $driver->getClient()->getResponse();

            Assert::assertEquals(201, $response->getStatusCode());
            $this->lastResponse = $response->getContent();
        }
    }

    /**
     * @When dodam go do wersji kalkulacji 1.54.2
     */
    public function dodamGoDoWersjiKalkulacji()
    {
    }

    /**
     * @Then taki produkt powinnen aktywować się w systemie i być dostępny dla kalkulacji leasingu.
     */
    public function takiProduktPowinnenAktywowacSieWSystemieIBycDostepnyDlaKalkulacjiLeasingu()
    {
        if ($this->lastResponse === null) {
            throw new PendingException('No response');
        }

        $this->assertJson($this->lastResponse);
        $lastResponse = json_decode($this->lastResponse, true, 512, JSON_THROW_ON_ERROR);
        Assert::assertArrayHasKey('id', $lastResponse);
        Product::query()->where('id', $lastResponse['id'])->firstOrFail();
    }

    /**
     * @When mam produkty leasingowe z takimi danymi:
     */
    public function mamProduktyLeasingoweZTakimiDanymi(TableNode $table)
    {
        $mapTypes = [
            'LpsMax' => 1,
            'PasMax' => 2,
            'None' => 0
        ];
        foreach ($table->getHash() as $row) {
            $command = new CreateProduct\Command(
                id: Uuid::fromString($row['Id']),
                productType: Product\ProductType::from($mapTypes[$row['type']]),
                name: $row['Nazwa produktu'],
                isCollective: $row['zbiorczy'] === 'tak',
                isLeasingProduct: $row['czy_leasingowy'] === 'tak',
                rpRatings: [
                    'a' => $row['rating a'],
                    'b' => $row['rating b'],
                    'c' => $row['rating c'],
                    's' => $row['rating s'],
                ],
            );

            $this->createProduct->__invoke($command);
        }
    }

    /**
     * @When usunę produkt o id :id
     */
    public function usuneProduktOId(string $id)
    {
        /**
         * @var \Soulcodex\Behat\Driver\KernelDriver $driver
         */
        $driver = $this->getSession()->getDriver();

        $driver->getClient()->request('DELETE', '/product/' . $id, [], [], [
            'CONTENT_TYPE' => 'application/json',
        ]);

        $response = $driver->getClient()->getResponse();

        Assert::assertEquals(200, $response->getStatusCode());
        $this->lastResponse = $response->getContent();
    }

    /**
     * @Then taki produkt powinnen zostać usunięty z bazy danych i nie być dostępny dla kalkulacji leasingu.
     */
    public function takiProduktPowinnenZostacUsunietyZBazyDanychINieBycDostepnyDlaKalkulacjiLeasingu()
    {
        if ($this->lastResponse === null) {
            throw new \LogicException('No response');
        }

        $this->assertJson($this->lastResponse);
        $lastResponse = json_decode($this->lastResponse, true, 512, JSON_THROW_ON_ERROR);
        Assert::assertArrayHasKey('id', $lastResponse);
        Assert::assertNull(Product::query()->where('id', $lastResponse['id'])->first());
    }
}
