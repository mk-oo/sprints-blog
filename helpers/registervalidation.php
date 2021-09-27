<?php
function validateEmptyString($request, $name, &$errors)
{
  if (!isset($request[$name]) || empty($request[$name])) {
    $errors[$name] = 'Please enter a valid ' . $name;
  }
}
function validateEmail($request, $name, &$errors)
{
  if (!isset($request[$name]) || empty($request[$name]) || !filter_var($request[$name], FILTER_VALIDATE_EMAIL)) {
    $errors[$name] = 'Please enter a valid ' . $name;
  }
}
function validateRequest()
{
  $errors = [];
  validateEmptyString($_REQUEST, 'name', $errors);
  validateEmptyString($_REQUEST, 'username', $errors);
  validateEmptyString($_REQUEST, 'password', $errors);
  validateEmptyString($_REQUEST, 'confirm_password', $errors);
  if (
    isset($_REQUEST['password']) && isset($_REQUEST['confirm_password'])
    && $_REQUEST['password'] != $_REQUEST['confirm_password']
  ) {
    $errors['password_confirm'] = 'Password confirmation does not match';
  }
  validateEmail($_REQUEST, 'email', $errors);
  return ['data' => $_REQUEST, 'errors' => $errors];
}
