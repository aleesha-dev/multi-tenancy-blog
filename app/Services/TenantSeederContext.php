<?php

namespace App\Services;

class TenantSeederContext
{
    private static ?self $instance = null;
    private array $context = [];

    /**
     * Private constructor to prevent direct instantiation.
     */
    private function __construct() {}

    /**
     * Get the singleton instance of the TenantSeederContext.
     *
     * @return self
     */
    public static function getInstance(): self
    {
        return self::$instance ??= new self();
    }

    /**
     * Set the context data.
     *
     * @param array $data 
     * @return void
     */
    public function set(array $data): void
    {
        $this->context = $data;
    }

    /**
     * Get a value from the context by key.
     *
     * @param string $key 
     * @param mixed $default 
     * @return mixed 
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->context[$key] ?? $default;
    }

    /**
     * Clear the context data.
     *
     * @return void
     */
    public function clear(): void
    {
        $this->context = [];
    }
}
