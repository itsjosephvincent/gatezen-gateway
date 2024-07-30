<?php

return [

    'model_not_found' => [
        'message' => ':model with ID: :id not found.',
    ],

    'server_error' => [
        'message' => 'Server error. Please try again. If the problem persists, contact your system administrator.',
    ],

    'throttle_exception' => [
        'message' => 'Too Many Request. Rate limit exceeded. Please try again later.',
    ],

    'invalid_blog_slug' => [
        'message' => 'There is no blog associated with the slug provided.',
    ],

    'invalid_news_slug' => [
        'message' => 'There is no news associated with the slug provided.',
    ],

    'invalid_credentials' => [
        'message' => 'Invalid login credentials.',
    ],

    'invalid_current_password' => [
        'message' => 'Current password entered is invalid.',
    ],

    'invalid_email' => [
        'message' => 'There is no account associated with the email address provided.',
    ],

    'invalid_reset_password_token' => [
        'message' => 'Invalid password reset token.',
    ],

    'reset_password_token_expired' => [
        'message' => 'The reset password token has already expired.',
    ],

    'invalid_2fa' => [
        'message' => 'Invalid google 2FA code.',
    ],

    'invalid_email_verification_token' => [
        'message' => 'Invalid email verification token.',
    ],

    'reset_password_email_sent' => [
        'message' => 'A forgot password email has been sent to your email address.',
    ],

    'empty_cart_exception' => [
        'message' => 'Cart empty.',
    ],

    'invalid_payment' => [
        'message' => 'Payment Unsuccessful.',
    ],

    'store_url_already_exists' => [
        'message' => 'Store URL already exists.',
    ],

    'store_does_not_exist' => [
        'message' => 'Store does not exist.',
    ],

    'invalid_payout_update' => [
        'message' => 'Updating of payout bank details is no longer possible.',
    ],

    'invalid_product_slug' => [
        'message' => 'Product not found.',
    ],

    'customer_already_exist' => [
        'message' => 'The customer already exists. Please specify a different name.',
    ],

    'invalid_filter' => [
        'message' => 'No data found.',
    ],

    'item_already_exist' => [
        'message' => 'Item name already exists.',
    ],

    'email_already_exist' => [
        'message' => 'Email already exists.',
    ],

    'invalid_adding_item' => [
        'message' => 'An error has occured, please try again.',
    ],

    'invalid_payout_request' => [
        'message' => 'Minimum payout amount should be :min_payout and up.',
    ],

    'user_already_exist' => [
        'message' => 'User already exist.',
    ],

    'user_does_not_exist' => [
        'message' => 'User does not exist.',
    ],

    'invalid_token' => [
        'message' => 'The secret key is invalid.',
    ],

    'token_not_found' => [
        'message' => 'A token is required for this request.',
    ],

    'invalid_country_exception' => [
        'message' => 'Sorry, currently we do not ship to :country.',
    ],

    'store_already_exist' => [
        'message' => 'Store already has owner.',
    ],

    'purchase_error_exception' => [
        'message' => 'An unexpected error occured while processing your purchase request.',
    ],

    'kyc_upload_exception' => [
        'message' => 'An unexpected error occured while uploading your document.',
    ],

    'no_portfolio_info' => [
        'message' => 'There is currently no portfolio information available for download.',
    ],

    'kyc_document_exist' => [
        'message' => 'You have already uploaded this type of document.',
    ],

    'user_is_blocked' => [
        'message' => 'Your account does not have the necessary permissions to perform this action.',
    ],

];
