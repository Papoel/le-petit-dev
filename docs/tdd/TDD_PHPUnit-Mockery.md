
## Exemple de TDD avec PHPUnit et Mockery

### 1. Écrire un test

Le test doit être écrit avant le code. Il doit être le plus simple possible.

```php
<?php

namespace App\Tests;

use App\Calculator;
use App\CalculatorInterface;
use App\CalculatorService;
use Faker\Factory;
use Mockery;
use PHPUnit\Framework\TestCase;

class CalculatorServiceTest extends TestCase
{
    public function testAdd()
    {
        $faker = Factory::create();

        $calculator = Mockery::mock(CalculatorInterface::class);
        $calculator->shouldReceive('add')->andReturn($faker->numberBetween());

        $calculatorService = new CalculatorService($calculator);
        $result = $calculatorService->add($faker->numberBetween(), $faker->numberBetween());
        $this->assertEquals($result, $result);
    }
}
```

### 2. Faire échouer le test

Le test doit échouer. Il ne doit pas passer.

```php
<?php

namespace App\Tests;

use App\Calculator;
use App\CalculatorInterface;
use App\CalculatorService;
use Faker\Factory;
use Mockery;
use PHPUnit\Framework\TestCase;

class CalculatorServiceTest extends TestCase
{
    public function testAdd()
    {
        $faker = Factory::create();

        $calculator = Mockery::mock(CalculatorInterface::class);
        $calculator->shouldReceive('add')->andReturn($faker->numberBetween());

        $calculatorService = new CalculatorService($calculator);
        $result = $calculatorService->add($faker->numberBetween(), $faker->numberBetween());
        $this->assertEquals($result, $result);
    }
}
```

### 3. Écrire le code

Le code doit être le plus simple possible pour que le test passe.

```php
<?php

namespace App;

class CalculatorService
{
    private $calculator;

    public function __construct(CalculatorInterface $calculator)
    {
        $this->calculator = $calculator;
    }

    public function add($a, $b)
    {
        return 0;
    }
}
```

### 4. Refactoriser le code

Le code doit être refactorisé pour qu'il soit le plus propre possible.

```php
<?php

namespace App;

class CalculatorService
{
    private $calculator;

    public function __construct(CalculatorInterface $calculator)
    {
        $this->calculator = $calculator;
    }

    public function add($a, $b)
    {
        return $this->calculator->add($a, $b);
    }
}
```
