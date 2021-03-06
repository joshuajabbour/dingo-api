<?php

namespace Dingo\Api\Routing;

use Illuminate\Routing\Route as IlluminateRoute;

class Route extends IlluminateRoute
{
    /**
     * {@inheritDoc}
     */
    protected function parseAction($action)
    {
        $action = parent::parseAction($action);

        if (isset($action['protected'])) {
            $action['protected'] = is_array($action['protected']) ? last($action['protected']) : $action['protected'];
        }

        if (isset($action['scopes'])) {
            $action['scopes'] = is_array($action['scopes']) ? $action['scopes'] : explode('|', $action['scopes']);
        }

        return $action;
    }

    /**
     * Determine if the route is protected.
     *
     * @return bool
     */
    public function isProtected()
    {
        return array_get($this->action, 'protected', false) === true;
    }

    /**
     * Set the routes protection.
     *
     * @param  bool  $protected
     * @return \Dingo\Api\Routing\Route
     */
    public function setProtected($protected)
    {
        $this->action['protected'] = $protected;

        return $this;
    }

    /**
     * Get the routes scopes.
     *
     * @return array
     */
    public function scopes()
    {
        return array_get($this->action, 'scopes', []);
    }

    /**
     * Add scopes to the route.
     *
     * @param  array  $scopes
     * @return \Dingo\Api\Routing\Route
     */
    public function addScopes(array $scopes)
    {
        if (! isset($this->action['scopes'])) {
            $this->action['scopes'] = [];
        }

        $this->action['scopes'] = array_merge($this->action['scopes'], $scopes);

        return $this;
    }
}
