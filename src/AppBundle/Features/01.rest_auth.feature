Feature: Testing REST authorization
  Scenario: Failed Admin login.
    Given I set "Content-Type" header equal to "application/x-www-form-urlencoded"
    When I send a POST request to "api/login_check" with body:
      """
      _username=ant&_password=wrong_password
      """
    Then the response status code should be 401
    And the response should be in JSON
    And the JSON node "code" should exist
    And the JSON node "code" should be equal to "401"
    And the JSON node "token" should not exist

  Scenario: Success Admin login.
    Given I set "Content-Type" header equal to "application/x-www-form-urlencoded"
    When I send a POST request to "api/login_check" with body:
      """
      _username=ant&_password=ant
      """
    Then the response should be in JSON
    And the JSON node "token" should exist
    And save auth token

  Scenario: Appointment list for Admin
    Given use auth token
    When I send a GET request to "api/appointments"
    Then the response status code should be 200
