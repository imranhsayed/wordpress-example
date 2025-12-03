// Generated from: tests/features/loginWPDashboard.feature
import { test } from "playwright-bdd";

test.describe('Login to WP Dashboard', () => {

  test('Successful login with valid credentials', async ({ Given, When, Then, page }) => { 
    await Given('I am on the WordPress login page', null, { page }); 
    await When('I enter a valid username and password', null, { page }); 
    await Then('I should see a welcome message', null, { page }); 
  });

});

// == technical section ==

test.use({
  $test: [({}, use) => use(test), { scope: 'test', box: true }],
  $uri: [({}, use) => use('tests/features/loginWPDashboard.feature'), { scope: 'test', box: true }],
  $bddFileData: [({}, use) => use(bddFileData), { scope: "test", box: true }],
});

const bddFileData = [ // bdd-data-start
  {"pwTestLine":6,"pickleLine":3,"tags":[],"steps":[{"pwStepLine":7,"gherkinStepLine":4,"keywordType":"Context","textWithKeyword":"Given I am on the WordPress login page","stepMatchArguments":[]},{"pwStepLine":8,"gherkinStepLine":5,"keywordType":"Action","textWithKeyword":"When I enter a valid username and password","stepMatchArguments":[]},{"pwStepLine":9,"gherkinStepLine":6,"keywordType":"Outcome","textWithKeyword":"Then I should see a welcome message","stepMatchArguments":[]}]},
]; // bdd-data-end