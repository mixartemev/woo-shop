SELECT
  ip.code                                                       AS 'Артикул',
  'simple'                                                      AS 'Тип',

  REPLACE(
      REPLACE(
          REPLACE(
              CONCAT('"',
                     LEFT(
                         REPLACE(
                             REPLACE(
                                 REPLACE(
                                     REPLACE(
                                         REPLACE(
                                             REPLACE(LEFT(ip.title, IF(LOCATE('вет в ассорт.', ip.title), LOCATE('вет в ассорт.', ip.title),
                                                                       IF(LOCATE(' ассорт.', ip.title), LOCATE(' ассорт.', ip.title),
                                                                          IF(LOCATE(' ПЛАСТ.', ip.title), LOCATE(' ПЛАСТ.', ip.title),
                                                                             IF(LOCATE(' РУСС.', ip.title), LOCATE(' РУСС.', ip.title),
                                                                                IF(LOCATE(' кор.', ip.title), LOCATE(' кор.', ip.title),
                                                                                   LOCATE('А КАРТ.', ip.title)
                                                                                )
                                                                             )
                                                                          )
                                                                       )
                                                                    ) - 3), '"', "'")
                                             , ' НА АККУМ.', '')
                                         , ' НА БАТ.', '')
                                     , ' СО СВЕТОМ', '')
                                 , 'СВЕТ+ЗВУК', '')
                             , ' Р/У', '')
                         , IF(LOCATE(',', ip.title), LOCATE(',', ip.title), LOCATE(' ', ip.title)) - 1)
              , '"')
              , ',"', '"')
          , ' ,', ',')
      , ',,', ',')
                                                                AS 'Имя',

  REPLACE(
      REPLACE(
          REPLACE(
              CONCAT('"',
                     REPLACE(
                         REPLACE(
                             REPLACE(
                                 REPLACE(
                                     REPLACE(
                                         REPLACE(LEFT(ip.title, IF(LOCATE('вет в ассорт.', ip.title), LOCATE('вет в ассорт.', ip.title),
                                                                   IF(LOCATE(' ассорт.', ip.title), LOCATE(' ассорт.', ip.title),
                                                                      IF(LOCATE(' ПЛАСТ.', ip.title), LOCATE(' ПЛАСТ.', ip.title),
                                                                         IF(LOCATE(' РУСС.', ip.title), LOCATE(' РУСС.', ip.title),
                                                                            IF(LOCATE(' кор.', ip.title), LOCATE(' кор.', ip.title),
                                                                               LOCATE('А КАРТ.', ip.title)
                                                                            )
                                                                         )
                                                                      )
                                                                   )
                                                                ) - 3), '"', "'")
                                         , ' НА АККУМ.', '')
                                     , ' НА БАТ.', '')
                                 , ' СО СВЕТОМ', '')
                             , 'СВЕТ+ЗВУК', '')
                         , ' Р/У', '')
              , '"')
              , ',"', '"')
          , ' ,', ',')
      , ',,', ',')
                                                                AS 'Короткое описание',
  1                                                             AS 'Опубликован',
  'visible'                                                     AS 'Видимость в каталоге',
  1                                                             AS 'В наличии?',
  ip.quantity                                                   AS 'Запасы',
  round(ip.price_1 * 3 / 100)                                   AS 'Базовая цена',
  g1.depth                                                      AS 'Длина (cm)',
  g1.width                                                      AS 'Ширина (cm)',
  g1.height                                                     AS 'Высота (cm)',
  1                                                             AS 'Разрешить обзоры от клиентов?',
  concat('http://img.simba-trade.ru/site1/', ip.code, '_c.jpg') AS 'Изображения',

  concat('"', CASE
              WHEN locate('динозавр', ip.title) OR locate('пони', ip.title)
                THEN 'Животные'
              WHEN locate('машин', ip.title) OR locate('трактор', ip.title) OR locate('грузовик', ip.title) OR locate('экскаватор', ip.title)
                THEN 'Машинки'
              WHEN locate('машин', ip.title) AND locate('вертолет', ip.title)
                THEN 'Машинки, Вертолеты'
              WHEN locate('джип', ip.title)
                THEN 'Машинки, Джипы'
              WHEN locate('НАСТОЛЬН', ip.title)
                THEN 'Настольные игры'
              WHEN locate('синтезатор', ip.title) OR locate('пианино', ip.title) OR locate('труба', ip.title) OR locate('гитара', ip.title) OR
                   locate('барабан', ip.title)
                THEN 'Муз. инструменты'
              WHEN locate('железная дорога', ip.title)
                THEN 'Железные дороги'
              WHEN locate('РОБОТ', ip.title)
                THEN 'Роботы'
              WHEN locate('кукла', ip.title) OR locate('кукол', ip.title) OR locate('пупс', ip.title)
                THEN 'Куклы'
              WHEN locate('ВЕРТОЛЕТ', ip.title)
                THEN 'Вертолеты'
              WHEN locate('КВАДРОКОПТЕР', ip.title)
                THEN 'Вертолеты, квадрокоптеры'
              WHEN locate('ТАНК', ip.title)
                THEN 'Танки'
              WHEN locate('парковка', ip.title) OR locate('конструктор', ip.title) /* OR locate('Парковка', ip.title)*/
                THEN 'Машинки'
              WHEN locate('пистолет', ip.title) OR locate('ружье', ip.title) OR locate('автомат', ip.title) OR locate('бластер', ip.title) OR
                   locate('лук', ip.title) OR locate('арбалет', ip.title)
                THEN 'Оружие'
              ELSE 'Другое'
              END, '"')                                         AS 'Категории',

  concat('"', TRIM(
      TRAILING ', ' FROM
      CONCAT(
          IF(locate('р/у', ip.title), 'Радиоуправляемые, ', ''),
          IF(locate('НА АККУМ', ip.title), 'На аккумуляторах, ', ''),
          IF(locate('НА БАТ.', ip.title), 'На батарейках, ', ''),
          IF(locate('СО СВЕТОМ', ip.title), 'Со светом, ', ''),
          IF(locate('СВЕТ+ЗВУК', ip.title), 'Со светом, Со звуком, ', ''),
          IF(locate('летает', ip.title), 'Летает, ', ''),
          IF(locate('ходит', ip.title), 'Ходит, ', '')
      )
  ), '"')
                                                                AS 'Метки',

  'пол'                                                         AS 'Имя атрибута 2',

  concat('"', if(locate('машин', ip.title), 'Для мальчиков',
                 if(locate('робот', ip.title), 'Для мальчиков',
                    if(locate('джип', ip.title), 'Для мальчиков',
                       if(locate('танк', ip.title), 'Для мальчиков',
                          if(locate('пистолет', ip.title), 'Для мальчиков',
                             if(locate('вертолет', ip.title), 'Для мальчиков',
                                if(locate('квадрокоптер', ip.title), 'Для мальчиков',
                                   if(locate('внедорожник', ip.title), 'Для мальчиков',
                                      if(locate('трактор', ip.title), 'Для мальчиков',
                                         if(locate('самолет', ip.title), 'Для мальчиков',
                                            if(locate('военн', ip.title), 'Для мальчиков',
                                               if(locate('ружье', ip.title), 'Для мальчиков',
                                                  if(locate('бластер', ip.title), 'Для мальчиков',
                                                     if(locate('полиц', ip.title), 'Для мальчиков',
                                                        if(locate('дрель', ip.title), 'Для мальчиков',
                                                           if(locate('футбол', ip.title), 'Для мальчиков',
                                                              if(locate('кукла', ip.title), 'Для девочек',
                                                                 if(locate('пупс', ip.title), 'Для девочек',
                                                                    if(locate('пони', ip.title), 'Для девочек',
                                                                       if(locate('касс', ip.title), 'Для девочек',
                                                                          if(locate('кухн', ip.title), 'Для девочек',
                                                                             if(locate('посуд', ip.title), 'Для девочек',
                                                                                if(locate('космети', ip.title), 'Для девочек',
                                                                                   if(locate('домик', ip.title), 'Для девочек',
                                                                                      if(locate('доктор', ip.title), 'Для девочек',
                                                                                         if(locate('конструктор', ip.title), 'Для девочек, Для мальчиков',
                                                                                            if(locate('настольн', ip.title), 'Для девочек, Для мальчиков',
                                                                                               if(locate('железная дорога', ip.title), 'Для мальчиков',
                                                                                                  if(locate('хоккей', ip.title), 'Для мальчиков',
                                                                                                     if(locate('ЛУК СО СТРЕЛ', ip.title), 'Для мальчиков',
                                                                                                        if(locate('шпион', ip.title), 'Для мальчиков',
                                                                                                           if(locate('автомат ', ip.title), 'Для мальчиков',
                                                                                                              if(locate('обуча', ip.title),
                                                                                                                 'Для девочек, Для мальчиков',
                                                                                                                 if(locate('синтезатор', ip.title),
                                                                                                                    'Для девочек, Для мальчиков',
                                                                                                                    if(locate('интерактив', ip.title),
                                                                                                                       'Для девочек, Для мальчиков',
                                                                                                                       if(locate('игра', ip.title),
                                                                                                                          'Для девочек, Для мальчиков',
                                                                                                                          if(locate('динозавр', ip.title),
                                                                                                                             'Для девочек, Для мальчиков',
                                                                                                                             if(locate('игрушка', ip.title),
                                                                                                                                'Для девочек, Для мальчиков',
                                                                                                                                if(locate('кукол', ip.title),
                                                                                                                                   'Для девочек',
                                                                                                                                   if(locate('мебел', ip.title),
                                                                                                                                      'Для девочек, Для мальчиков',
                                                                                                                                      if(locate('автобус',
                                                                                                                                                ip.title),
                                                                                                                                         'Для мальчиков',
                                                                                                                                         if(locate('зеркал',
                                                                                                                                                   ip.title),
                                                                                                                                            'Для девочек',
                                                                                                                                            if(locate('поезд',
                                                                                                                                                      ip.title),
                                                                                                                                               'Для девочек, Для мальчиков',
                                                                                                                                               if(locate(
                                                                                                                                                      'развива',
                                                                                                                                                      ip.title),
                                                                                                                                                  'Для девочек, Для мальчиков',
                                                                                                                                                  ''
                                                                                                                                               )
                                                                                                                                            )
                                                                                                                                         )
                                                                                                                                      )
                                                                                                                                   )
                                                                                                                                )
                                                                                                                             )
                                                                                                                          )
                                                                                                                       )
                                                                                                                    )
                                                                                                                 )
                                                                                                              )
                                                                                                           )
                                                                                                        )
                                                                                                     )
                                                                                                  )
                                                                                               )
                                                                                            )
                                                                                         )
                                                                                      )
                                                                                   )
                                                                                )
                                                                             )
                                                                          )
                                                                       )
                                                                    )
                                                                 )
                                                              )
                                                           )
                                                        )
                                                     )
                                                  )
                                               )
                                            )
                                         )
                                      )
                                   )
                                )
                             )
                          )
                       )
                    )
                 )
  ), '"')
                                                                AS 'Значение(-я) аттрибута(-ов) 2'

FROM items_payments ip, goods1 g1
WHERE g1.id = ip.code AND clients_id = 50679
GROUP BY ip.code
ORDER BY clients_payment_history_id DESC
LIMIT 200

INTO OUTFILE '/var/lib/mysql-files/export.csv'
FIELDS ENCLOSED BY ''
  TERMINATED BY ','
  ESCAPED BY ''
LINES TERMINATED BY '\r\n';