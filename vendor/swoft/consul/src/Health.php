<?php declare(strict_types=1);


namespace Swoft\Consul;


use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Consul\Contract\HealthInterface;
use Swoft\Consul\Exception\ClientException;
use Swoft\Consul\Exception\ServerException;
use Swoft\Consul\Helper\OptionsResolver;

/**
 * Class Health
 *
 * @since 2.0
 *
 * @Bean()
 */
class Health implements HealthInterface
{
    /**
     * @Inject()
     *
     * @var Consul
     */
    private $consul;

    /**
     * @param string $node
     * @param array  $options
     *
     * @return Response
     * @throws ClientException
     * @throws ServerException
     */
    public function node(string $node, array $options = []): Response
    {
        $params = [
            'query' => OptionsResolver::resolve($options, ['dc']),
        ];

        return $this->consul->get('/v1/health/node/' . $node, $params);
    }

    /**
     * @param string $service
     * @param array  $options
     *
     * @return Response
     * @throws ClientException
     * @throws ServerException
     */
    public function checks(string $service, array $options = []): Response
    {
        $params = [
            'query' => OptionsResolver::resolve($options, ['dc']),
        ];

        return $this->consul->get('/v1/health/checks/' . $service, $params);
    }

    /**
     * @param string $service
     * @param array  $options
     *
     * @return Response
     * @throws ClientException
     * @throws ServerException
     */
    public function service(string $service, array $options = []): Response
    {
        $params = [
            'query' => OptionsResolver::resolve($options, ['dc', 'tag', 'passing']),
        ];

        return $this->consul->get('/v1/health/service/' . $service, $params);
    }

    /**
     * @param string $state
     * @param array  $options
     *
     * @return Response
     * @throws ClientException
     * @throws ServerException
     */
    public function state(string $state, array $options = []): Response
    {
        $params = [
            'query' => OptionsResolver::resolve($options, ['dc']),
        ];

        return $this->consul->get('/v1/health/state/' . $state, $params);
    }
}
