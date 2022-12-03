SELECT cu.id,cu.symbol,
	IFNULL(
			(
			SELECT IF(@fromDate IS NULL AND @fd_month IS NULL, 0, SUM(amount)) AS total_begin_amount
			FROM tr_cashes
			WHERE `status` = 1
			AND currency_id = cu.id
			AND IF(@createdBy, created_by = @createdBY, TRUE)
			AND (IF(@fromDate, tr_date < @fromDate, FALSE) OR IF(@fd_month, `month` < @fd_month, FALSE))
			)
			,0
		)AS begin_ammount,
	IFNULL(
			(
			SELECT SUM(amount) AS total_cash_in
			FROM tr_cashes
			WHERE `type` IN (1, 4)
			AND `status` = 1
			AND currency_id = cu.id
			AND IF(@fromDate, tr_date >= @fromDate, TRUE)
			AND IF(@toDate, tr_date <= @toDate, TRUE)
			AND IF(@fd_month, `month` = @fd_month, TRUE)
			AND IF(@itemId, item_id = @itemId, TRUE)
			AND IF(@otherName, other_name LIKE CONCAT('%', @otherName, '%'), TRUE)
			AND IF(@depatment, (to_from_id = @depatment AND `type` = 2), TRUE)
			AND IF(@TYPE, `type` = @type, TRUE)
			AND IF(@createdBy, created_by = @createdBy, TRUE)
			)
			,0
		) AS cash_in,
	IFNULL(
			(
			SELECT SUM(amount) AS total_expend
			FROM tr_cashes
			WHERE `type` IN (2, 3)
			AND `status` = 1
			AND currency_id = cu.id
			AND IF(@fromDate, tr_date >= @fromDate, TRUE)
			AND IF(@toDate, tr_date <= @toDate, TRUE)
			AND IF(@fd_month, `month` = @fd_month, TRUE)
			AND IF(@itemId, item_id = @itemId, TRUE)
			AND IF(@otherName, other_name LIKE CONCAT('%', @otherName, '%'), TRUE)
			AND IF(@depatment, (to_from_id = @depatment AND `type` = 2), TRUE)
			AND IF(@TYPE, `type` = @type, TRUE)
			AND IF(@createdBy, created_by = @createdBy, TRUE)
			)
			,0
		) AS expend,
	IFNULL(
			(
			SELECT SUM(amount) AS total_cash
			FROM tr_cashes
			WHERE `status` = 1
			AND currency_id = cu.id
			AND IF(@fromDate, tr_date >= @fromDate, TRUE)
			AND IF(@toDate, tr_date <= @toDate, TRUE)
			AND IF(@fd_month, `month` = @fd_month, TRUE)
			AND IF(@itemId, item_id = @itemId, TRUE)
			AND IF(@otherName, other_name LIKE CONCAT('%', @otherName, '%'), TRUE)
			AND IF(@depatment, (to_from_id = @depatment AND `type` = 2), TRUE)
			AND IF(@TYPE, `type` = @type, TRUE)
			AND IF(@createdBy, created_by = @createdBy, TRUE)
			)
			,0
		) AS total_cash
FROM currencies AS cu WHERE cu.status = 'ENABLED';
