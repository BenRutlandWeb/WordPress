<?php

/**
 * User API: WP_Role class
 *
 * @package WordPress
 * @subpackage Users
 * @since 4.4.0
 */

/**
 * Core class used to extend the user roles API.
 *
 * @since 2.0.0
 */
#[AllowDynamicProperties]
class WP_Role
{
    /**
     * Role name.
     *
     * @since 2.0.0
     * @var string
     */
    public string $name;

    /**
     * List of capabilities the role contains.
     *
     * @since 2.0.0
     * @var bool[] Array of key/value pairs where keys represent a capability name and boolean values
     *             represent whether the role has that capability.
     */
    public array $capabilities;

    /**
     * Constructor - Set up object properties.
     *
     * The list of capabilities must have the key as the name of the capability
     * and the value a boolean of whether it is granted to the role.
     *
     * @since 2.0.0
     *
     * @param string $role         Role name.
     * @param bool[] $capabilities Array of key/value pairs where keys represent a capability name and boolean values
     *                             represent whether the role has that capability.
     */
    public function __construct(string $role, array $capabilities)
    {
        $this->name         = $role;
        $this->capabilities = $capabilities;
    }

    /**
     * Assign role a capability.
     *
     * @since 2.0.0
     *
     * @param string $cap   Capability name.
     * @param bool   $grant Whether role has capability privilege.
     */
    public function add_cap(string $cap, bool $grant = true): void
    {
        $this->capabilities[$cap] = $grant;
        wp_roles()->add_cap($this->name, $cap, $grant);
    }

    /**
     * Removes a capability from a role.
     *
     * @since 2.0.0
     *
     * @param string $cap Capability name.
     */
    public function remove_cap(string $cap): void
    {
        unset($this->capabilities[$cap]);
        wp_roles()->remove_cap($this->name, $cap);
    }

    /**
     * Determines whether the role has the given capability.
     *
     * @since 2.0.0
     *
     * @param string $cap Capability name.
     * @return bool Whether the role has the given capability.
     */
    public function has_cap(string $cap): bool
    {
        /**
         * Filters which capabilities a role has.
         *
         * @since 2.0.0
         *
         * @param bool[] $capabilities Array of key/value pairs where keys represent a capability name and boolean values
         *                             represent whether the role has that capability.
         * @param string $cap          Capability name.
         * @param string $name         Role name.
         */
        $capabilities = apply_filters('role_has_cap', $this->capabilities, $cap, $this->name);

        if (!empty($capabilities[$cap])) {
            return $capabilities[$cap];
        } else {
            return false;
        }
    }
}
