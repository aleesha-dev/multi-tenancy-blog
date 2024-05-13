<?php

namespace App\Enums;

enum RolePermission: string
{
    case CREATE_BLOG = 'create_blog';
    case VIEW_OWN_BLOG = 'view_own_blog';
    case VIEW_ALL_BLOGS = 'view_all_blogs';
    case EDIT_OWN_BLOG = 'edit_own_blog';
    case EDIT_ANY_BLOG = 'edit_any_blog';
    case DELETE_OWN_BLOG = 'delete_own_blog';
    case DELETE_ANY_BLOG = 'delete_any_blog';
    case DETAIL_OWN_BLOG = 'detail_own_blog';
    case DETAIL_ANY_BLOG = 'detail_any_blog';
    case FORCE_DELETE_OWN_BLOG = 'force_delete_own_blog';
    case FORCE_DELETE_ANY_BLOG = 'force_delete_any_blog';
    case RESTORE_OWN_BLOG = 'restore_own_blog';
    case RESTORE_ANY_BLOG = 'restore_any_blog';

    public static function all(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match ($this) {
            self::CREATE_BLOG => 'Create Blog',
            self::VIEW_OWN_BLOG => 'View Own Blog',
            self::VIEW_ALL_BLOGS => 'View All Blogs',
            self::EDIT_OWN_BLOG => 'Edit Own Blog',
            self::EDIT_ANY_BLOG => 'Edit Any Blog',
            self::DELETE_OWN_BLOG => 'Delete Own Blog',
            self::DELETE_ANY_BLOG => 'Delete Any Blog',
            self::DETAIL_OWN_BLOG => 'Detail Own Blog',
            self::DETAIL_ANY_BLOG => 'Detail Any Blog',
            self::FORCE_DELETE_OWN_BLOG => 'Force Delete Own Blog',
            self::FORCE_DELETE_ANY_BLOG => 'Force Delete Any Blog',
            self::RESTORE_OWN_BLOG => 'Restore Own Blog',
            self::RESTORE_ANY_BLOG => 'Restore Any Blog',
        };
    }
}
