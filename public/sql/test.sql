SELECT ct.id, ct.tr_date, ct.item_name, ct.amount, ct.balance, ct.user_balance, cu.symbol, cu.code,
	ct.to_from,u.name AS `owner`, ct.type, if(ct.item_name IN ('Add Cash','Transfer'), toUser.name, if(ct.item_name = 'Exchange', toCur.code, dp.name)) AS to_from
FROM 
cash_transactions AS ct INNER JOIN items AS it ON ct.item_id = it.id 
INNER JOIN users AS u ON ct.owner = u.id 
INNER JOIN depatments AS dp ON ct.to_from = dp.id
INNER JOIN currencies AS cu ON ct.currency_id = cu.id
INNER JOIN users AS toUser ON ct.to_from = toUser.id
INNER JOIN currencies AS toCur ON ct.to_from =  toCur.id

ORDER BY ct.id ASC ;

# UPDATE globle balance
UPDATE `cash_transactions` mctr
SET balance = (SELECT SUM(amount) 
	FROM cash_transactions 
	WHERE currency_id = mctr.currency_id AND `status` != 'DELETED'
		AND (tr_date < mctr.tr_date OR (id <= mctr.id AND tr_date = mctr.tr_date)));

# UPDATE USER balance 
UPDATE `cash_transactions` mctr
SET user_balance = (SELECT SUM(amount) 
	FROM cash_transactions 
	WHERE currency_id = mctr.currency_id AND `owner` = mctr.owner AND `status` != 'DELETED'
		AND (tr_date < mctr.tr_date OR (id <= mctr.id AND tr_date = mctr.tr_date)));

# Recalculate cash_transaction balance
UPDATE `cash_transactions` mctr
SET balance = (SELECT SUM(amount) 
	FROM cash_transactions 
	WHERE currency_id = mctr.currency_id AND `status` != 'DELETED'
		AND (tr_date < mctr.tr_date OR (id <= mctr.id AND tr_date = mctr.tr_date))),

    user_balance = (SELECT SUM(amount) 
	FROM cash_transactions 
	WHERE currency_id = mctr.currency_id AND `owner` = mctr.owner AND `status` != 'DELETED'
		AND (tr_date < mctr.tr_date OR (id <= mctr.id AND tr_date = mctr.tr_date)));

# SELECT USER balance 		
SELECT currency_id, `owner`, SUM(amount) AS user_balance FROM cash_transactions GROUP BY currency_id, `owner`;

# INSERT OR UPDATE
INSERT INTO table (id, name, age) VALUES(1, "A", 19) ON DUPLICATE KEY UPDATE    
name="A", age=19

# re calculate Balances
INSERT INTO balances (currency_id, user_id, current_balance)
SELECT currency_id AS currency_id, 0 AS user_id, SUM(amount) AS balance FROM cash_transactions GROUP BY currency_id
UNION 		
SELECT currency_id AS currency_id, `owner` AS user_id, SUM(amount) AS balance FROM cash_transactions GROUP BY currency_id, `owner`
ON DUPLICATE KEY UPDATE    
current_balance = VALUES(current_balance);