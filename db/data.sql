START TRANSACTION;

-- ---------------------------------------------------------------------------------------------------------------------
-- Role
-- ---------------------------------------------------------------------------------------------------------------------

INSERT INTO
    role
    (id, name, priv)
VALUES
    (1, 'admin', '["_all_"]');

SELECT SETVAL('role_id_seq', 1);

-- ---------------------------------------------------------------------------------------------------------------------
-- Account
-- ---------------------------------------------------------------------------------------------------------------------

INSERT INTO
    account
    (name, password, role_id)
VALUES
    ('admin', '$2y$10$FZSRqIGNKq64P3Rz27jlzuKuSZ9Rik9qHnqk5zH2Z7d67.erqaNhy', 1);

-- ---------------------------------------------------------------------------------------------------------------------
-- Page
-- ---------------------------------------------------------------------------------------------------------------------

INSERT INTO
    page
    (id, name, slug, menu, status, entity)
VALUES
    (1, 'Homepage', 'index', TRUE, 'published', 'page_content');

SELECT SETVAL('page_id_seq', 1);


-- ---------------------------------------------------------------------------------------------------------------------

COMMIT;
