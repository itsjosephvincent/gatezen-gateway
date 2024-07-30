<?php

return [
    'ignore_users' => [
        '304257364@qq.com',
        'a.bayanov@academ-it.ru',
        'a.bayanov10@academ-it.ru',
        'a.bayanov11@academ-it.ru',
        'a.bayanov12@academ-it.ru',
        'a.bayanov13@academ-it.ru',
        'a.bayanov14@academ-it.ru',
        'a.bayanov14@academ-it.ru',
        'a.bayanov5@academ-it.ru',
        'a.bayanov8@academ-it.ru',
        'a.bayanov9@academ-it.ru',
        'admin@onrees.com',
        'asd@sdf.de',
        'h@d.com',
        'haavard.aurstad@thegateindex.com',
        'mail2@example.com',
        'mail3@example.com',
        'manager@onrees.com',
        'mokshinpv@gmail.com',
        'n.tsolakis@outlook.com',
        'n.tsolakis@outlook.com',
        'nectariostsolakis@gmail.com',
        'no@no.no',
        'one@test.com',
        'positionten@thegateindex.com',
        's@d.ru',
        'superadmin@onrees.com',
        'support@thegateindex.com',
        'test@example.com',
        'test@user.com',
        'test1@email.com',
        'test123@test123.com',
        'test7@example.com',
        'test8@example.com',
        'test9@example.com',
        'tsolakis@gmail.com',
        'tsolakis@gmail.comxx',
        'tsolakis@msn.comx',
        'tsolakis123@gmail.com',
        'tsolakisx@gmail.com',
        'tsolakisxxf@gmail.com',
    ],
    'zoho_thesis_invoices' => [
        'PD7195', 'PD7196', 'PD7197', 'PD7198', 'PD7199', 'PD7200', 'PD7201', 'PD7202', 'PD7203', 'PD7204', 'PD7205', 'PD7206', 'PD7207', 'PD7208', 'PD7209', 'PD7222', 'PD7223', 'PD7226', 'PD7227', 'PD7210', 'PD7211', 'PD7212', 'PD7213', 'PD7214', 'PD7215', 'PD7216', 'PD7217', 'PD7218', 'PD7219', 'PD7220', 'PD7221', 'PD7224', 'PD7225',
    ],
    // 'zoho_thesis_invoices' => [
    //     '3%' => [
    //         'PD7007','PD7008','PD7009','PD7010','PD7011','PD7012','PD7013','PD7014','PD7015','PD7016','PD7017','PD7018','PD7019','PD7020','PD7021','PD7022','PD7023','PD7024','PD7025','PD7026','PD7027','PD7029','PD7030','PD7031','PD7032','PD7033','PD7034','PD7035','PD7036','PD7037','PD7038','PD7039','PD7040','PD7041','PD7042','PD7043','PD7044','PD7045','PD7046','PD7047','PD7048','PD7210','PD7211','PD7212','PD7213','PD7214','PD7215','PD7216','PD7217','PD7218','PD7219','PD7220','PD7221','PD7224','PD7225'
    //     ],
    //     '5%' => [
    //         'PD7195','PD7196','PD7197','PD7198','PD7199','PD7200','PD7201','PD7202','PD7203','PD7204','PD7205','PD7206','PD7207','PD7208','PD7209','PD7222','PD7223','PD7226','PD7227'
    //     ]
    // ],
    'Craftwill Capital ESG' => [
        'db_connection' => env('TGI_DB_CONNECTION'),
        'db_host' => env('TGI_DB_HOST'),
        'db_port' => env('TGI_DB_PORT'),
        'db_name' => env('TGI_DATABASE'),
        'db_username' => env('TGI_DATABASE_USERNAME'),
        'db_password' => env('TGI_DATABASE_PASSWORD'),
        'shares_query' => 'SELECT
                            u.UserID,
                            u.Email,
                            u.FirstName,
                            u.LastName,
                            tr.RoleName,
                            u.DisplayName,
                            sa1.SharesAccountID as CWIOP_ID,
                            sa1.balance_qty as CWIOP,
                            sa2.SharesAccountID as CWISC_ID,
                            sa2.balance_qty as CWISC,
                            sa1.updated_at as TransactionDate,
                            MAX(CASE WHEN up.PropertyDefinitionID = 49 THEN up.PropertyValue END) as Company,
                            MAX(CASE WHEN up.PropertyDefinitionID = 79 THEN up.PropertyValue END) as CompanyName,
                            MAX(CASE WHEN up.PropertyDefinitionID = 28 THEN up.PropertyValue END) as MobileNumber,
                            MAX(CASE WHEN up.PropertyDefinitionID = 37 THEN up.PropertyValue END) as Unit,
                            MAX(CASE WHEN up.PropertyDefinitionID = 38 THEN up.PropertyValue END) as Street,
                            MAX(CASE WHEN up.PropertyDefinitionID = 39 THEN up.PropertyValue END) as City,
                            MAX(CASE WHEN up.PropertyDefinitionID = 40 THEN up.PropertyValue END) as Country,
                            MAX(CASE WHEN up.PropertyDefinitionID = 41 THEN up.PropertyValue END) as Region,
                            MAX(CASE WHEN up.PropertyDefinitionID = 42 THEN up.PropertyValue END) as PostalCode
                        FROM Users as u
                        LEFT JOIN tgiSharesAccount as sa1 ON u.UserID = sa1.UserID AND sa1.ShareTypeId = 1 AND sa1.PortalID = 0
                        LEFT JOIN tgiSharesAccount as sa2 ON u.UserID = sa2.UserID AND sa2.ShareTypeId = 2 AND sa2.PortalID = 0
                        LEFT JOIN UserRoles as ur ON u.UserID = ur.UserID
                        LEFT JOIN Roles as tr ON ur.RoleID = tr.RoleID
                        LEFT JOIN UserProfile AS up ON u.UserID = up.UserID
                        GROUP BY u.UserID, u.Email, u.FirstName, u.LastName, tr.RoleName, u.DisplayName, sa1.SharesAccountID, sa1.balance_qty, sa2.SharesAccountID, sa2.balance_qty, sa1.updated_at
                        ORDER BY u.UserID, tr.RoleName ASC',
        'users_query' => 'SELECT u.UserID, u.Email, u.FirstName, u.LastName, tr.RoleName, u.DisplayName,
                            MAX(CASE WHEN up.PropertyDefinitionID = 49 THEN up.PropertyValue END) as Company,
                            MAX(CASE WHEN up.PropertyDefinitionID = 79 THEN up.PropertyValue END) as CompanyName,
                            MAX(CASE WHEN up.PropertyDefinitionID = 28 THEN up.PropertyValue END) as MobileNumber,
                            MAX(CASE WHEN up.PropertyDefinitionID = 37 THEN up.PropertyValue END) as Unit,
                            MAX(CASE WHEN up.PropertyDefinitionID = 38 THEN up.PropertyValue END) as Street,
                            MAX(CASE WHEN up.PropertyDefinitionID = 39 THEN up.PropertyValue END) as City,
                            MAX(CASE WHEN up.PropertyDefinitionID = 40 THEN up.PropertyValue END) as Country,
                            MAX(CASE WHEN up.PropertyDefinitionID = 41 THEN up.PropertyValue END) as Region,
                            MAX(CASE WHEN up.PropertyDefinitionID = 42 THEN up.PropertyValue END) as PostalCode
                        FROM Users AS u
                        LEFT JOIN UserRoles AS ur ON u.UserID = ur.UserID
                        LEFT JOIN Roles AS tr ON ur.RoleID = tr.RoleID
                        LEFT JOIN UserProfile AS up ON u.UserID = up.UserID
                        GROUP BY u.UserID, u.Email, u.FirstName, u.LastName, tr.RoleName, u.DisplayName
                        ORDER BY u.UserID, tr.RoleName ASC',
        'bank_transaction_query' => 'SELECT u.UserID, u.Email, u.FirstName, u.LastName, b.Amount, b.Description, b.CreatedOnDate FROM Users as u
                        LEFT JOIN tgibanktransactions as b on u.UserID = b.UserId
                        WHERE b.PortalId = 0 AND b.TransactionType = 0 AND b.Status = 1
                        ORDER BY u.UserID',
        'CWIOP_ticker' => 'CWIOP',
        'CWISC_ticker' => 'CWISC',
        'user_data_type' => 'TGI User',
        'share_data_type' => 'TGI Share',
        'transaction_data_type' => 'TGI Transaction',
        'roles' => [
            'Affiliate',
            'Partner 200',
            'Partner 400',
            'Partner 500',
            'Partner 600',
            'Partner 800',
            'Partner 1,250',
            'Partner 1,800',
            'Partner 2,400',
            'Partner 2,500',
            'Partner 5,000',
            'Partner 10,000',
            'Partner 15,000',
            'Partner 25,000',
            'Partner 50,000',
            'Partner 100,000',
        ],
    ],
    'REES' => [
        'db_connection' => env('REES_DB_CONNECTION'),
        'db_host' => env('REES_DB_HOST'),
        'db_port' => env('REES_DB_PORT'),
        'db_name' => env('REES_DATABASE'),
        'db_username' => env('REES_DATABASE_USERNAME'),
        'db_password' => env('REES_DATABASE_PASSWORD'),
        'shares_query' => "SELECT u.id AS UserID, u.firstname AS FirstName, u.lastname AS LastName, u.email AS Email, w.id as WalletID, w.slug AS WalletType, t.amount AS Balance, json_unquote(json_extract(t.meta, '$.description')) as Description, t.type AS TransactionType, t.wallet_id as TransactionWalletID, t.amount as Amount, t.updated_at as TransactionDate FROM users AS u
                            LEFT JOIN accounts AS a ON u.id = a.user_id
                            LEFT JOIN wallets AS w ON a.id = w.holder_id
                            LEFT JOIN transactions AS t ON t.wallet_id = w.id
                            WHERE w.slug IN ('token', 'share') AND t.type = 'deposit'
                            ORDER BY u.id",
        'users_query' => 'SELECT id AS UserID, firstname AS FirstName, lastname AS LastName, email AS Email FROM users ORDER BY id',
        'share_ticker' => 'RPAH-B',
        'token_ticker' => 'RPAH-T',
        'user_data_type' => 'REES User',
        'share_data_type' => 'REES Share',
    ],
    'ABC Biotech' => [
        'db_connection' => env('ABC_DB_CONNECTION'),
        'db_host' => env('ABC_DB_HOST'),
        'db_port' => env('ABC_DB_PORT'),
        'db_name' => env('ABC_DATABASE'),
        'db_username' => env('ABC_DATABASE_USERNAME'),
        'db_password' => env('ABC_DATABASE_PASSWORD'),
        'shares_query' => 'SELECT u.UserID, u.FirstName, u.LastName, u.Email, s.AccountID as WalletID, s.Balance AS Balance, s.CreatedOnDate as TransactionDate
                                FROM Users AS u
                                LEFT JOIN ReesAccount AS s ON u.UserID = s.UserID
                                WHERE s.PortalID = 5 AND s.Balance > 0
                                ORDER BY u.UserID',
        'users_query' => 'SELECT u.UserID, u.FirstName, u.LastName, u.Email FROM Users as u
                            LEFT JOIN ReesAccount AS s ON u.UserID = s.UserID
                            WHERE s.PortalID = 5
                            ORDER BY UserID',
        'share_ticker' => 'GBMT-CY',
        'equal_shares' => [
            // 'GBMT-UK', Disabled for now due, agreed with G.
            'ABCB-A',
            'AQWT-B',
        ],
        'user_data_type' => 'ABC User',
        'share_data_type' => 'ABC Share',
    ],
];
