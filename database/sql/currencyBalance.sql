-- Total expend
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
AND IF(@createdBy, created_by = @createdBy, TRUE);

-- Total Cas IN
SELECT SUM(amount) AS total_income
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
AND IF(@createdBy, created_by = @createdBy, TRUE);

-- Total begin amount
SELECT SUM(amount)AS total_begin_amount
FROM tr_cashes
WHERE `status` = 1
AND IF(@fd_month, IF(@fromDate, `tr_date` < IF(@fd_month >= @fromDate, @fd_month, @fromDate), `month` < @fd_month ), IF(@fromDate, `tr_date` < @fromDate, FALSE ) )
AND currency_id = 106
AND created_by = IFNULL(@createdBy, TRUE);

-- Total last balance
SELECT SUM(amount) AS total_payment
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
;

-- Total begin amount new way
SELECT IF(@fromDate IS NULL AND @fd_month IS NULL, 0, SUM(amount)) AS total_begin_amount
FROM tr_cashes
WHERE `status` = 1
AND currency_id = 106
AND IF(@createdBy, created_by = @createdBY, TRUE)
AND (IF(@fromDate, tr_date < @fromDate, FALSE) OR IF(@fd_month, `month` < @fd_month, FALSE))
;
