<?php

/**
 * A helper file for Dcat Admin, to provide autocomplete information to your IDE
 *
 * This file should not be included in your code, only analyzed by your IDE!
 *
 * @author jqh <841324345@qq.com>
 */
namespace Dcat\Admin {
    use Illuminate\Support\Collection;

    /**
     * @property Grid\Column|Collection id
     * @property Grid\Column|Collection category
     * @property Grid\Column|Collection content
     * @property Grid\Column|Collection created_at
     * @property Grid\Column|Collection updated_at
     * @property Grid\Column|Collection name
     * @property Grid\Column|Collection type
     * @property Grid\Column|Collection version
     * @property Grid\Column|Collection detail
     * @property Grid\Column|Collection is_enabled
     * @property Grid\Column|Collection parent_id
     * @property Grid\Column|Collection order
     * @property Grid\Column|Collection icon
     * @property Grid\Column|Collection uri
     * @property Grid\Column|Collection extension
     * @property Grid\Column|Collection permission_id
     * @property Grid\Column|Collection menu_id
     * @property Grid\Column|Collection slug
     * @property Grid\Column|Collection http_method
     * @property Grid\Column|Collection http_path
     * @property Grid\Column|Collection role_id
     * @property Grid\Column|Collection user_id
     * @property Grid\Column|Collection value
     * @property Grid\Column|Collection username
     * @property Grid\Column|Collection password
     * @property Grid\Column|Collection avatar
     * @property Grid\Column|Collection remember_token
     * @property Grid\Column|Collection endpoint
     * @property Grid\Column|Collection example
     * @property Grid\Column|Collection url
     * @property Grid\Column|Collection uuid
     * @property Grid\Column|Collection connection
     * @property Grid\Column|Collection queue
     * @property Grid\Column|Collection payload
     * @property Grid\Column|Collection exception
     * @property Grid\Column|Collection failed_at
     * @property Grid\Column|Collection major
     * @property Grid\Column|Collection minor
     * @property Grid\Column|Collection patch
     * @property Grid\Column|Collection updated
     * @property Grid\Column|Collection original_name
     * @property Grid\Column|Collection folder
     * @property Grid\Column|Collection imageable_id
     * @property Grid\Column|Collection imageable_type
     * @property Grid\Column|Collection attempts
     * @property Grid\Column|Collection reserved_at
     * @property Grid\Column|Collection available_at
     * @property Grid\Column|Collection sub_header
     * @property Grid\Column|Collection img
     * @property Grid\Column|Collection intro
     * @property Grid\Column|Collection link
     * @property Grid\Column|Collection feeling
     * @property Grid\Column|Collection moon_id
     * @property Grid\Column|Collection num1
     * @property Grid\Column|Collection num2
     * @property Grid\Column|Collection num3
     * @property Grid\Column|Collection num4
     * @property Grid\Column|Collection num5
     * @property Grid\Column|Collection num6
     * @property Grid\Column|Collection money
     * @property Grid\Column|Collection ip
     * @property Grid\Column|Collection count
     * @property Grid\Column|Collection email
     * @property Grid\Column|Collection token
     * @property Grid\Column|Collection tokenable_type
     * @property Grid\Column|Collection tokenable_id
     * @property Grid\Column|Collection abilities
     * @property Grid\Column|Collection last_used_at
     * @property Grid\Column|Collection category_id
     * @property Grid\Column|Collection post_id
     * @property Grid\Column|Collection public
     * @property Grid\Column|Collection secret
     * @property Grid\Column|Collection is_completed
     * @property Grid\Column|Collection site_id
     * @property Grid\Column|Collection status
     * @property Grid\Column|Collection domain
     * @property Grid\Column|Collection online
     * @property Grid\Column|Collection get_type
     * @property Grid\Column|Collection path
     * @property Grid\Column|Collection date_xpath
     * @property Grid\Column|Collection date_format
     * @property Grid\Column|Collection last_updated_at
     * @property Grid\Column|Collection project_id
     * @property Grid\Column|Collection phone
     * @property Grid\Column|Collection email_verified_at
     * @property Grid\Column|Collection app_id
     * @property Grid\Column|Collection peak_connection_count
     * @property Grid\Column|Collection websocket_message_count
     * @property Grid\Column|Collection api_message_count
     * @property Grid\Column|Collection rank
     * @property Grid\Column|Collection emoji
     *
     * @method Grid\Column|Collection id(string $label = null)
     * @method Grid\Column|Collection category(string $label = null)
     * @method Grid\Column|Collection content(string $label = null)
     * @method Grid\Column|Collection created_at(string $label = null)
     * @method Grid\Column|Collection updated_at(string $label = null)
     * @method Grid\Column|Collection name(string $label = null)
     * @method Grid\Column|Collection type(string $label = null)
     * @method Grid\Column|Collection version(string $label = null)
     * @method Grid\Column|Collection detail(string $label = null)
     * @method Grid\Column|Collection is_enabled(string $label = null)
     * @method Grid\Column|Collection parent_id(string $label = null)
     * @method Grid\Column|Collection order(string $label = null)
     * @method Grid\Column|Collection icon(string $label = null)
     * @method Grid\Column|Collection uri(string $label = null)
     * @method Grid\Column|Collection extension(string $label = null)
     * @method Grid\Column|Collection permission_id(string $label = null)
     * @method Grid\Column|Collection menu_id(string $label = null)
     * @method Grid\Column|Collection slug(string $label = null)
     * @method Grid\Column|Collection http_method(string $label = null)
     * @method Grid\Column|Collection http_path(string $label = null)
     * @method Grid\Column|Collection role_id(string $label = null)
     * @method Grid\Column|Collection user_id(string $label = null)
     * @method Grid\Column|Collection value(string $label = null)
     * @method Grid\Column|Collection username(string $label = null)
     * @method Grid\Column|Collection password(string $label = null)
     * @method Grid\Column|Collection avatar(string $label = null)
     * @method Grid\Column|Collection remember_token(string $label = null)
     * @method Grid\Column|Collection endpoint(string $label = null)
     * @method Grid\Column|Collection example(string $label = null)
     * @method Grid\Column|Collection url(string $label = null)
     * @method Grid\Column|Collection uuid(string $label = null)
     * @method Grid\Column|Collection connection(string $label = null)
     * @method Grid\Column|Collection queue(string $label = null)
     * @method Grid\Column|Collection payload(string $label = null)
     * @method Grid\Column|Collection exception(string $label = null)
     * @method Grid\Column|Collection failed_at(string $label = null)
     * @method Grid\Column|Collection major(string $label = null)
     * @method Grid\Column|Collection minor(string $label = null)
     * @method Grid\Column|Collection patch(string $label = null)
     * @method Grid\Column|Collection updated(string $label = null)
     * @method Grid\Column|Collection original_name(string $label = null)
     * @method Grid\Column|Collection folder(string $label = null)
     * @method Grid\Column|Collection imageable_id(string $label = null)
     * @method Grid\Column|Collection imageable_type(string $label = null)
     * @method Grid\Column|Collection attempts(string $label = null)
     * @method Grid\Column|Collection reserved_at(string $label = null)
     * @method Grid\Column|Collection available_at(string $label = null)
     * @method Grid\Column|Collection sub_header(string $label = null)
     * @method Grid\Column|Collection img(string $label = null)
     * @method Grid\Column|Collection intro(string $label = null)
     * @method Grid\Column|Collection link(string $label = null)
     * @method Grid\Column|Collection feeling(string $label = null)
     * @method Grid\Column|Collection moon_id(string $label = null)
     * @method Grid\Column|Collection num1(string $label = null)
     * @method Grid\Column|Collection num2(string $label = null)
     * @method Grid\Column|Collection num3(string $label = null)
     * @method Grid\Column|Collection num4(string $label = null)
     * @method Grid\Column|Collection num5(string $label = null)
     * @method Grid\Column|Collection num6(string $label = null)
     * @method Grid\Column|Collection money(string $label = null)
     * @method Grid\Column|Collection ip(string $label = null)
     * @method Grid\Column|Collection count(string $label = null)
     * @method Grid\Column|Collection email(string $label = null)
     * @method Grid\Column|Collection token(string $label = null)
     * @method Grid\Column|Collection tokenable_type(string $label = null)
     * @method Grid\Column|Collection tokenable_id(string $label = null)
     * @method Grid\Column|Collection abilities(string $label = null)
     * @method Grid\Column|Collection last_used_at(string $label = null)
     * @method Grid\Column|Collection category_id(string $label = null)
     * @method Grid\Column|Collection post_id(string $label = null)
     * @method Grid\Column|Collection public(string $label = null)
     * @method Grid\Column|Collection secret(string $label = null)
     * @method Grid\Column|Collection is_completed(string $label = null)
     * @method Grid\Column|Collection site_id(string $label = null)
     * @method Grid\Column|Collection status(string $label = null)
     * @method Grid\Column|Collection domain(string $label = null)
     * @method Grid\Column|Collection online(string $label = null)
     * @method Grid\Column|Collection get_type(string $label = null)
     * @method Grid\Column|Collection path(string $label = null)
     * @method Grid\Column|Collection date_xpath(string $label = null)
     * @method Grid\Column|Collection date_format(string $label = null)
     * @method Grid\Column|Collection last_updated_at(string $label = null)
     * @method Grid\Column|Collection project_id(string $label = null)
     * @method Grid\Column|Collection phone(string $label = null)
     * @method Grid\Column|Collection email_verified_at(string $label = null)
     * @method Grid\Column|Collection app_id(string $label = null)
     * @method Grid\Column|Collection peak_connection_count(string $label = null)
     * @method Grid\Column|Collection websocket_message_count(string $label = null)
     * @method Grid\Column|Collection api_message_count(string $label = null)
     * @method Grid\Column|Collection rank(string $label = null)
     * @method Grid\Column|Collection emoji(string $label = null)
     */
    class Grid {}

    class MiniGrid extends Grid {}

    /**
     * @property Show\Field|Collection id
     * @property Show\Field|Collection category
     * @property Show\Field|Collection content
     * @property Show\Field|Collection created_at
     * @property Show\Field|Collection updated_at
     * @property Show\Field|Collection name
     * @property Show\Field|Collection type
     * @property Show\Field|Collection version
     * @property Show\Field|Collection detail
     * @property Show\Field|Collection is_enabled
     * @property Show\Field|Collection parent_id
     * @property Show\Field|Collection order
     * @property Show\Field|Collection icon
     * @property Show\Field|Collection uri
     * @property Show\Field|Collection extension
     * @property Show\Field|Collection permission_id
     * @property Show\Field|Collection menu_id
     * @property Show\Field|Collection slug
     * @property Show\Field|Collection http_method
     * @property Show\Field|Collection http_path
     * @property Show\Field|Collection role_id
     * @property Show\Field|Collection user_id
     * @property Show\Field|Collection value
     * @property Show\Field|Collection username
     * @property Show\Field|Collection password
     * @property Show\Field|Collection avatar
     * @property Show\Field|Collection remember_token
     * @property Show\Field|Collection endpoint
     * @property Show\Field|Collection example
     * @property Show\Field|Collection url
     * @property Show\Field|Collection uuid
     * @property Show\Field|Collection connection
     * @property Show\Field|Collection queue
     * @property Show\Field|Collection payload
     * @property Show\Field|Collection exception
     * @property Show\Field|Collection failed_at
     * @property Show\Field|Collection major
     * @property Show\Field|Collection minor
     * @property Show\Field|Collection patch
     * @property Show\Field|Collection updated
     * @property Show\Field|Collection original_name
     * @property Show\Field|Collection folder
     * @property Show\Field|Collection imageable_id
     * @property Show\Field|Collection imageable_type
     * @property Show\Field|Collection attempts
     * @property Show\Field|Collection reserved_at
     * @property Show\Field|Collection available_at
     * @property Show\Field|Collection sub_header
     * @property Show\Field|Collection img
     * @property Show\Field|Collection intro
     * @property Show\Field|Collection link
     * @property Show\Field|Collection feeling
     * @property Show\Field|Collection moon_id
     * @property Show\Field|Collection num1
     * @property Show\Field|Collection num2
     * @property Show\Field|Collection num3
     * @property Show\Field|Collection num4
     * @property Show\Field|Collection num5
     * @property Show\Field|Collection num6
     * @property Show\Field|Collection money
     * @property Show\Field|Collection ip
     * @property Show\Field|Collection count
     * @property Show\Field|Collection email
     * @property Show\Field|Collection token
     * @property Show\Field|Collection tokenable_type
     * @property Show\Field|Collection tokenable_id
     * @property Show\Field|Collection abilities
     * @property Show\Field|Collection last_used_at
     * @property Show\Field|Collection category_id
     * @property Show\Field|Collection post_id
     * @property Show\Field|Collection public
     * @property Show\Field|Collection secret
     * @property Show\Field|Collection is_completed
     * @property Show\Field|Collection site_id
     * @property Show\Field|Collection status
     * @property Show\Field|Collection domain
     * @property Show\Field|Collection online
     * @property Show\Field|Collection get_type
     * @property Show\Field|Collection path
     * @property Show\Field|Collection date_xpath
     * @property Show\Field|Collection date_format
     * @property Show\Field|Collection last_updated_at
     * @property Show\Field|Collection project_id
     * @property Show\Field|Collection phone
     * @property Show\Field|Collection email_verified_at
     * @property Show\Field|Collection app_id
     * @property Show\Field|Collection peak_connection_count
     * @property Show\Field|Collection websocket_message_count
     * @property Show\Field|Collection api_message_count
     * @property Show\Field|Collection rank
     * @property Show\Field|Collection emoji
     *
     * @method Show\Field|Collection id(string $label = null)
     * @method Show\Field|Collection category(string $label = null)
     * @method Show\Field|Collection content(string $label = null)
     * @method Show\Field|Collection created_at(string $label = null)
     * @method Show\Field|Collection updated_at(string $label = null)
     * @method Show\Field|Collection name(string $label = null)
     * @method Show\Field|Collection type(string $label = null)
     * @method Show\Field|Collection version(string $label = null)
     * @method Show\Field|Collection detail(string $label = null)
     * @method Show\Field|Collection is_enabled(string $label = null)
     * @method Show\Field|Collection parent_id(string $label = null)
     * @method Show\Field|Collection order(string $label = null)
     * @method Show\Field|Collection icon(string $label = null)
     * @method Show\Field|Collection uri(string $label = null)
     * @method Show\Field|Collection extension(string $label = null)
     * @method Show\Field|Collection permission_id(string $label = null)
     * @method Show\Field|Collection menu_id(string $label = null)
     * @method Show\Field|Collection slug(string $label = null)
     * @method Show\Field|Collection http_method(string $label = null)
     * @method Show\Field|Collection http_path(string $label = null)
     * @method Show\Field|Collection role_id(string $label = null)
     * @method Show\Field|Collection user_id(string $label = null)
     * @method Show\Field|Collection value(string $label = null)
     * @method Show\Field|Collection username(string $label = null)
     * @method Show\Field|Collection password(string $label = null)
     * @method Show\Field|Collection avatar(string $label = null)
     * @method Show\Field|Collection remember_token(string $label = null)
     * @method Show\Field|Collection endpoint(string $label = null)
     * @method Show\Field|Collection example(string $label = null)
     * @method Show\Field|Collection url(string $label = null)
     * @method Show\Field|Collection uuid(string $label = null)
     * @method Show\Field|Collection connection(string $label = null)
     * @method Show\Field|Collection queue(string $label = null)
     * @method Show\Field|Collection payload(string $label = null)
     * @method Show\Field|Collection exception(string $label = null)
     * @method Show\Field|Collection failed_at(string $label = null)
     * @method Show\Field|Collection major(string $label = null)
     * @method Show\Field|Collection minor(string $label = null)
     * @method Show\Field|Collection patch(string $label = null)
     * @method Show\Field|Collection updated(string $label = null)
     * @method Show\Field|Collection original_name(string $label = null)
     * @method Show\Field|Collection folder(string $label = null)
     * @method Show\Field|Collection imageable_id(string $label = null)
     * @method Show\Field|Collection imageable_type(string $label = null)
     * @method Show\Field|Collection attempts(string $label = null)
     * @method Show\Field|Collection reserved_at(string $label = null)
     * @method Show\Field|Collection available_at(string $label = null)
     * @method Show\Field|Collection sub_header(string $label = null)
     * @method Show\Field|Collection img(string $label = null)
     * @method Show\Field|Collection intro(string $label = null)
     * @method Show\Field|Collection link(string $label = null)
     * @method Show\Field|Collection feeling(string $label = null)
     * @method Show\Field|Collection moon_id(string $label = null)
     * @method Show\Field|Collection num1(string $label = null)
     * @method Show\Field|Collection num2(string $label = null)
     * @method Show\Field|Collection num3(string $label = null)
     * @method Show\Field|Collection num4(string $label = null)
     * @method Show\Field|Collection num5(string $label = null)
     * @method Show\Field|Collection num6(string $label = null)
     * @method Show\Field|Collection money(string $label = null)
     * @method Show\Field|Collection ip(string $label = null)
     * @method Show\Field|Collection count(string $label = null)
     * @method Show\Field|Collection email(string $label = null)
     * @method Show\Field|Collection token(string $label = null)
     * @method Show\Field|Collection tokenable_type(string $label = null)
     * @method Show\Field|Collection tokenable_id(string $label = null)
     * @method Show\Field|Collection abilities(string $label = null)
     * @method Show\Field|Collection last_used_at(string $label = null)
     * @method Show\Field|Collection category_id(string $label = null)
     * @method Show\Field|Collection post_id(string $label = null)
     * @method Show\Field|Collection public(string $label = null)
     * @method Show\Field|Collection secret(string $label = null)
     * @method Show\Field|Collection is_completed(string $label = null)
     * @method Show\Field|Collection site_id(string $label = null)
     * @method Show\Field|Collection status(string $label = null)
     * @method Show\Field|Collection domain(string $label = null)
     * @method Show\Field|Collection online(string $label = null)
     * @method Show\Field|Collection get_type(string $label = null)
     * @method Show\Field|Collection path(string $label = null)
     * @method Show\Field|Collection date_xpath(string $label = null)
     * @method Show\Field|Collection date_format(string $label = null)
     * @method Show\Field|Collection last_updated_at(string $label = null)
     * @method Show\Field|Collection project_id(string $label = null)
     * @method Show\Field|Collection phone(string $label = null)
     * @method Show\Field|Collection email_verified_at(string $label = null)
     * @method Show\Field|Collection app_id(string $label = null)
     * @method Show\Field|Collection peak_connection_count(string $label = null)
     * @method Show\Field|Collection websocket_message_count(string $label = null)
     * @method Show\Field|Collection api_message_count(string $label = null)
     * @method Show\Field|Collection rank(string $label = null)
     * @method Show\Field|Collection emoji(string $label = null)
     */
    class Show {}

    /**
     
     */
    class Form {}

}

namespace Dcat\Admin\Grid {
    /**
     
     */
    class Column {}

    /**
     
     */
    class Filter {}
}

namespace Dcat\Admin\Show {
    /**
     
     */
    class Field {}
}
