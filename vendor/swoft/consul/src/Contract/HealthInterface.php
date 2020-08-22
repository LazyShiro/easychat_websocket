<?php declare(strict_types=1);


namespace Swoft\Consul\Contract;

use Swoft\Consul\Response;

/**
 * Class HealthInterface
 *
 * @since 2.0
 */
interface HealthInterface
{
    /**
     * @param string $node
     * @param array  $options
     *
     * @return Response
     */
    public function node(string $node, array $options = []): Response;

    /**
     * @param string $service
     * @param array  $options
     *
     * @return Response
     */
    public function checks(string $service, array $options = []): Response;

    /**
     * @param string $service
     * @param array  $options
     *
     * @return Response
     */
    public function service(string $service, array $options = []): Response;

    /**
     * @param string $state
     * @param array  $options
     *
     * @return Response
     */
    public function state(string $state, array $options = []): Response;
}
