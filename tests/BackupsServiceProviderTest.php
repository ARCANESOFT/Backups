<?php namespace Arcanesoft\Backups\Tests;

use Arcanesoft\Backups\BackupsServiceProvider;

/**
 * Class     BackupsServiceProviderTest
 *
 * @package  Arcanesoft\Backups\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class BackupsServiceProviderTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \Arcanesoft\Backups\BackupsServiceProvider */
    protected $provider;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    protected function setUp()
    {
        parent::setUp();

        $this->provider = $this->app->getProvider(BackupsServiceProvider::class);
    }

    protected function tearDown()
    {
        unset($this->provider);

        parent::tearDown();
    }

    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_can_be_instantiated()
    {
        $expectations = [
            \Illuminate\Support\ServiceProvider::class,
            \Arcanedev\Support\ServiceProvider::class,
            \Arcanedev\Support\PackageServiceProvider::class,
            \Arcanesoft\Core\Bases\PackageServiceProvider::class,
            \Arcanesoft\Backups\BackupsServiceProvider::class,
        ];

        foreach ($expectations as $expected) {
            $this->assertInstanceOf($expected, $this->provider);
        }
    }

    /** @test */
    public function it_can_provides()
    {
        $expected = [
            //
        ];

        $this->assertSame($expected, $this->provider->provides());
    }
}
