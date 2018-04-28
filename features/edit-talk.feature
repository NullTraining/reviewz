@talk
Feature:
  As a speaker
  I shoould be able to edit my talk

  Scenario: Speaker has rights to edit talk title
    Given Given "Alex Smith" is a speaker on the talk "Alexis talk"
    When speaker change talk title to "New Alexis talk"
    Then the talk title is "New Alexis talk"

  Scenario: Speaker has rights to edit talk description
    Given "Alex Smith" is a speaker on a "Alexis talk"
    When speaker change talk description to "New Description for Talk"
    Then the talk description is "New Description for Talk"

