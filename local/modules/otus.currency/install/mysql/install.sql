create table if not exists b_otus_currency
(
	CURRENCY char(3) not null,
	AMOUNT_CNT int not null default 1,
	AMOUNT decimal(18, 4) null,
	SORT int not null default 100,
	DATE_UPDATE datetime not null,
	NUMCODE char(3) null,
	BASE char(1) not null default 'N',
	CREATED_BY int(18) null,
	DATE_CREATE datetime null,
	MODIFIED_BY int(18) null,
	CURRENT_BASE_RATE decimal(26, 12) null,
	primary key (CURRENCY)
);
INSERT INTO b_otus_currency 
(CURRENCY, AMOUNT_CNT, AMOUNT, SORT, DATE_UPDATE, NUMCODE, BASE, CREATED_BY, DATE_CREATE, MODIFIED_BY, CURRENT_BASE_RATE)
VALUES
('USD', 1, 1.0000, 100, NOW(), '840', 'Y', 1, NOW(), 1, 1.000000000000),
('EUR', 1, 1.0900, 200, NOW(), '978', 'N', 1, NOW(), 1, 1.090000000000),
('CNY', 1, 0.1400, 300, NOW(), '156', 'N', 1, NOW(), 1, 0.140000000000),
('JPY', 1, 0.006700, 400, NOW(), '392', 'N', 1, NOW(), 1, 0.006700000000),
('GBP', 1, 1.2700, 500, NOW(), '826', 'N', 1, NOW(), 1, 1.270000000000),
('CHF', 1, 1.1300, 600, NOW(), '756', 'N', 1, NOW(), 1, 1.130000000000),
('CAD', 1, 0.7300, 700, NOW(), '124', 'N', 1, NOW(), 1, 0.730000000000),
('AUD', 1, 0.6600, 800, NOW(), '036', 'N', 1, NOW(), 1, 0.660000000000),
('HKD', 1, 0.1280, 900, NOW(), '344', 'N', 1, NOW(), 1, 0.128000000000),
('SGD', 1, 0.7400, 1000, NOW(), '702', 'N', 1, NOW(), 1, 0.740000000000);