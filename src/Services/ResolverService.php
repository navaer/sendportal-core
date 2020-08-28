<?php

namespace Sendportal\Base\Services;

class ResolverService
{

    /**
     * @var array
     */
    private $resolvers = [];

    /**
     * @param callable $callable\
     */
    public function setHeaderHtmlContentResolver(callable $callable)
    {
        $this->setResolver('header', $callable);
    }

    /**
     * @return string|null
     */
    public function resolveHeaderHtmlContent():?string
    {
        $resolver = $this->getResolver('header');

        return $resolver();
    }

    /**
     * @param callable $callable
     */
    public function setSiderbarHtmlContentResolver(callable $callable)
    {
        $this->setResolver('sidebar', $callable);
    }

    /**
     * @return string|null
     */
    public function resolveSiderbarHtmlContent():?string
    {
        $resolver = $this->getResolver('sidebar');

        return $resolver();
    }

    /**
     * @param callable $callable
     */
    public function setCurrentWorkspaceIdResolver(callable $callable)
    {
        $this->setResolver('workspace', $callable);
    }

    /**
     * @return int|null
     */
    public function resolveCurrentWorkspaceId():?int
    {
        $resolver = $this->getResolver('workspace');

        return $resolver();
    }

    /**
     * @param $resolverName
     * @return mixed
     */
    private function getResolver(string $resolverName): callable
    {
        return $this->resolvers[$resolverName];
    }

    /**
     * @param string $resolverName
     * @param callable $callable
     */
    private function setResolver(string $resolverName, callable $callable)
    {
        $this->resolvers[$resolverName] = $callable;
    }
}