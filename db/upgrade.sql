START TRANSACTION;

-- Replace all trigger functions!

-- ---------------------------------------------------------------------------------------------------------------------
-- Account
-- ---------------------------------------------------------------------------------------------------------------------

ALTER TABLE account RENAME COLUMN role TO role_id;

-- ---------------------------------------------------------------------------------------------------------------------
-- File
-- ---------------------------------------------------------------------------------------------------------------------

ALTER TABLE file DROP COLUMN type;
ALTER TABLE file RENAME COLUMN ent TO entity;

-- ---------------------------------------------------------------------------------------------------------------------
-- Page
-- ---------------------------------------------------------------------------------------------------------------------

ALTER TABLE page ADD COLUMN meta_title varchar(80) NOT NULL DEFAULT '';
ALTER TABLE page RENAME COLUMN meta TO meta_description;
ALTER TABLE page RENAME COLUMN menuname TO menu_name;
ALTER TABLE page RENAME COLUMN parent TO parent_id;
ALTER TABLE page RENAME COLUMN ent TO entity;

-- ---------------------------------------------------------------------------------------------------------------------
-- Version
-- ---------------------------------------------------------------------------------------------------------------------

ALTER TABLE version RENAME COLUMN page TO page_id;

-- ---------------------------------------------------------------------------------------------------------------------

COMMIT;
