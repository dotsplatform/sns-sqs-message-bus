<?php
/**
 * Description of Message.php.
 *
 * @copyright Copyright (c) DOTSPLATFORM, LLC
 * @author    Yehor Herasymchuk <yehor@dotsplatform.com>
 */

namespace Dots\MessageBus\Entities;

abstract class MessageName
{
    public const SUFFIX_CREATED = 'CREATED';

    public const SUFFIX_UPDATED = 'UPDATED';

    public const CMS_LANG_CREATED = 'CMS_LANG_CREATED';

    public const CMS_LANG_UPDATED = 'CMS_LANG_UPDATED';

    public const CMS_APP_TOKEN_CREATED = 'CMS_APP_TOKEN_CREATED';

    public const CMS_APP_TOKEN_UPDATED = 'CMS_APP_TOKEN_UPDATED';

    public const CMS_ACCOUNTS_CREATED = 'CMS_ACCOUNTS_CREATED';

    public const CMS_ACCOUNTS_UPDATED = 'CMS_ACCOUNTS_UPDATED';

    public const CMS_ACCOUNT_LANGS_CREATED = 'CMS_ACCOUNT_LANGS_CREATED';

    public const CMS_ACCOUNT_LANGS_UPDATED = 'CMS_ACCOUNT_LANGS_UPDATED';

    public const CMS_CITIES_CREATED = 'CMS_CITIES_CREATED';

    public const CMS_CITIES_UPDATED = 'CMS_CITIES_UPDATED';

    public const CMS_CITY_CATEGORIES_CREATED = 'CMS_CITY_CATEGORIES_CREATED';

    public const CMS_CITY_CATEGORIES_UPDATED = 'CMS_CITY_CATEGORIES_UPDATED';

    public const CMS_CITY_CATEGORIES_COMPANIES_UPDATED = 'CMS_CITY_CATEGORIES_COMPANIES_UPDATED';

    public const CMS_DELIVERIES_CREATED = 'CMS_DELIVERIES_CREATED';

    public const CMS_DELIVERIES_UPDATED = 'CMS_DELIVERIES_UPDATED';

    public const CMS_ACTIONS_CREATED = 'CMS_ACTIONS_CREATED';

    public const CMS_ACTIONS_UPDATED = 'CMS_ACTIONS_UPDATED';

    public const CMS_ACTIONS_DISHES_UPDATED = 'CMS_ACTIONS_DISHES_UPDATED';

    public const CMS_COMPANIES_CREATED = 'CMS_COMPANIES_CREATED';

    public const CMS_COMPANIES_UPDATED = 'CMS_COMPANIES_UPDATED';

    public const CMS_COMPANY_ADDRESSES_CREATED = 'CMS_COMPANY_ADDRESSES_CREATED';

    public const CMS_COMPANY_ADDRESSES_UPDATED = 'CMS_COMPANY_ADDRESSES_UPDATED';

    public const CMS_COMPANY_CATEGORIES_CREATED = 'CMS_COMPANY_CATEGORIES_CREATED';

    public const CMS_COMPANY_CATEGORIES_UPDATED = 'CMS_COMPANY_CATEGORIES_UPDATED';

    public const CMS_COMPANY_CATEGORIES_DELETED = 'CMS_COMPANY_CATEGORIES_DELETED';

    public const CMS_COMPANY_CATEGORIES_MODIFIER_GROUPS_UPDATED = 'CMS_COMPANY_CATEGORIES_MODIFIER_GROUPS_UPDATED';

    public const CMS_ITEMS_CREATED = 'CMS_ITEMS_CREATED';

    public const CMS_ITEMS_UPDATED = 'CMS_ITEMS_UPDATED';

    public const CMS_ITEMS_DELETED = 'CMS_ITEMS_DELETED';

    public const CMS_ITEMS_MODIFIER_GROUPS_UPDATED = 'CMS_ITEMS_MODIFIER_GROUPS_UPDATED';

    public const CMS_MODIFIERS_CREATED = 'CMS_MODIFIERS_CREATED';

    public const CMS_MODIFIERS_UPDATED = 'CMS_MODIFIERS_UPDATED';

    public const CMS_MODIFIERS_DELETED = 'CMS_MODIFIERS_DELETED';

    public const CMS_MODIFIER_GROUPS_CREATED = 'CMS_MODIFIER_GROUPS_CREATED';

    public const CMS_MODIFIER_GROUPS_UPDATED = 'CMS_MODIFIER_GROUPS_UPDATED';

    public const CMS_MODIFIER_GROUPS_DELETED = 'CMS_MODIFIER_GROUPS_DELETED';

    public const CMS_MODIFIER_GROUPS_MODIFIERS_UPDATED = 'CMS_MODIFIER_GROUPS_MODIFIERS_UPDATED';

    public const CMS_PACKAGES_CREATED = 'CMS_PACKAGES_CREATED';

    public const CMS_PACKAGES_UPDATED = 'CMS_PACKAGES_UPDATED';

    public const CMS_REVIEWS_CREATED = 'CMS_REVIEWS_CREATED';

    public const CMS_REVIEWS_UPDATED = 'CMS_REVIEWS_UPDATED';

    public const CMS_SETTINGS_CREATED = 'CMS_SETTINGS_CREATED';

    public const CMS_SETTINGS_UPDATED = 'CMS_SETTINGS_UPDATED';

    public const CMS_USERS_CREATED = 'CMS_USERS_CREATED';

    public const CMS_USERS_UPDATED = 'CMS_USERS_UPDATED';

    public const CMS_USER_ADDRESSES_CREATED = 'CMS_USER_ADDRESSES_CREATED';

    public const CMS_USER_ADDRESSES_UPDATED = 'CMS_USER_ADDRESSES_UPDATED';

    public const CMS_AUTH_TOKEN_CREATED = 'CMS_AUTH_TOKEN_CREATED';

    public const CMS_AUTH_TOKEN_UPDATED = 'CMS_AUTH_TOKEN_UPDATED';

    public const CMS_AUTH_TOKEN_DELETED = 'CMS_AUTH_TOKEN_DELETED';

    public const CMS_API_TOKEN_CREATED = 'CMS_API_TOKEN_CREATED';

    public const CMS_API_TOKEN_UPDATED = 'CMS_API_TOKEN_UPDATED';

    public const CMS_API_TOKEN_DELETED = 'CMS_API_TOKEN_DELETED';

    public const CMS_ORDER_CREATED = 'CMS_ORDER_CREATED';

    public const CMS_ORDER_UPDATED = 'CMS_ORDER_UPDATED';

    public const CMS_ROLE_CREATED = 'CMS_ROLE_CREATED';

    public const CMS_ROLE_UPDATED = 'CMS_ROLE_UPDATED';

    public const CMS_AB_TEST_CREATED = 'CMS_AB_TEST_CREATED';

    public const CMS_AB_TEST_UPDATED = 'CMS_AB_TEST_UPDATED';

    public const CMS_AB_TEST_DELETED = 'CMS_AB_TEST_DELETED';
}
