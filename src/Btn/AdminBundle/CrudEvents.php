<?php

namespace Btn\AdminBundle;

final class CrudEvents
{
    /**
     * Event that is triggerd when new entity was created via crud controller.
     */
    const ENTITY_CREATED = 'btn_admin.crud.entity_created';
    /**
     * Event that is triggerd when entity was updated via crud controller.
     */
    const ENTITY_UPDATED = 'btn_admin.crud.entity_updated';
    /**
     * Event that is triggerd when entity was deleted via crud controller.
     */
    const ENTITY_DELETED = 'btn_admin.crud.entity_deleted';
}
