DELIMITER |

-- STATE 1: EXPIRED
-- STATE 4: ACTIVE

DROP PROCEDURE IF EXISTS FAST_REFRESH_AVAILABILITIES;
CREATE PROCEDURE FAST_REFRESH_AVAILABILITIES()
BEGIN
    UPDATE places SET disponible = true WHERE id IN (SELECT id_place FROM reservations WHERE type_statut = 4 AND date_expiration < NOW());
    UPDATE reservations SET type_statut = 1 WHERE type_statut = 4 AND date_expiration < NOW();
END
|

DROP PROCEDURE IF EXISTS FULL_REFRESH_AVAILABILITIES;
CREATE PROCEDURE FULL_REFRESH_AVAILABILITIES()
BEGIN
    UPDATE places SET disponible = true;
    UPDATE reservations SET type_statut = 1 WHERE type_statut = 4 AND date_expiration < NOW();
    UPDATE places SET disponible = false WHERE id IN (SELECT id_place FROM reservations WHERE type_statut = 4);
END
|

DELIMITER ;

