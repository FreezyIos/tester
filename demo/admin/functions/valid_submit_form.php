<?php
function valid_submit_form($post, $required_fields)
{

  if (
    isset($post['user_name']) && empty($post['user_name']) && $required_fields['config_is_name_required']
  ) {
    return 'NAMEISREQUIRED';
  }

  if (
    isset($post['user_tel']) && !empty($post['user_tel']) &&
    $post['user_tel_valid'] == 'false'
  ) {
    return 'ERRORMINLENGTHTEL';
  }

  if (
    isset($post['user_tel']) && empty($post['user_tel']) && $required_fields['config_is_tel_required']
  ) {
    return 'TELISREQUIRED';
  }

  if (
    isset($post['user_mail']) && empty($post['user_mail']) && $required_fields['config_is_email_required']
  ) {
    return 'MAILISREQUIRED';
  }

  if (
    isset($post['user_street']) && empty($post['user_street']) && $required_fields['config_is_street_required']
  ) {
    return 'STREETISREQUIRED';
  }

  if (
    isset($post['user_city']) && empty($post['user_city']) && $required_fields['config_is_city_required']
  ) {
    return 'CITYISREQUIRED';
  }

  if (
    isset($post['user_house_number']) && empty($post['user_house_number']) && $required_fields['config_is_house_number_required']
  ) {
    return 'HOUSENUMBERISREQUIRED';
  }

  if (
    isset($post['user_apartment_number']) && empty($post['user_apartment_number']) && $required_fields['config_is_apartment_number_required']
  ) {
    return 'APARTMENTNUMBERISREQUIRED';
  }

  if (
    isset($post['user_postindex']) && empty($post['user_postindex'])
    && $required_fields['config_is_postcode_required']
  ) {
    return 'POSTINDEXISREQUIRED';
  }

  if (
    isset($post['user_comment']) && empty($post['user_comment'])
    && $required_fields['config_is_comment_required']
  ) {
    return 'COMMENTISREQUIRED';
  }

  return true;
}
