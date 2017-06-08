<?php declare(strict_types=1);

namespace ApiGen\ModularConfiguration\Parameter;

use ApiGen\ModularConfiguration\Contract\Parameter\ParameterProviderInterface;
use Nette\DI\Container;
use Symfony\Component\DependencyInjection\Container as SymfonyContainer;

final class ParameterProvider implements ParameterProviderInterface
{
    /**
     * @var mixed[]
     */
    private $parameters = [];

    public function __construct(SymfonyContainer $symfonyContainer = null, Container $netteContainer = null)
    {
        if ($symfonyContainer) {
            $this->parameters = $symfonyContainer->getParameterBag();
        } elseif ($netteContainer) {
            $containerParameters = $netteContainer->getParameters();
            $this->parameters = $this->unsedNetteDefaultParameters($containerParameters);
        }
    }

    /**
     * @return mixed[]
     */
    public function provide(): array
    {
        return $this->parameters;
    }

    /**
     * @param mixed[] $containerParameters
     * @return mixed[]
     */
    private function unsedNetteDefaultParameters(array $containerParameters): array
    {
        unset(
            $containerParameters['appDir'], $containerParameters['wwwDir'],
            $containerParameters['debugMode'], $containerParameters['productionMode'],
            $containerParameters['consoleMode'], $containerParameters['tempDir']
        );

        return $containerParameters;
    }
}
