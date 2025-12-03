// Generated from: tests/features/homepageHeartbeat.feature
import { test } from "playwright-bdd";

test.describe('Homepage Heartbeat', () => {

  test('Verify Homepage Accessibility', async ({ Given, When, Then, page }) => { 
    await Given('the homepage is deployed to production', null, { page }); 
    await When('a user navigates to the homepage', null, { page }); 
    await Then('the user sees "Hello, Polaris!" displayed on the page', null, { page }); 
  });

});

// == technical section ==

test.use({
  $test: [({}, use) => use(test), { scope: 'test', box: true }],
  $uri: [({}, use) => use('tests/features/homepageHeartbeat.feature'), { scope: 'test', box: true }],
  $bddFileData: [({}, use) => use(bddFileData), { scope: "test", box: true }],
});

const bddFileData = [ // bdd-data-start
  {"pwTestLine":6,"pickleLine":7,"tags":[],"steps":[{"pwStepLine":7,"gherkinStepLine":8,"keywordType":"Context","textWithKeyword":"Given the homepage is deployed to production","stepMatchArguments":[]},{"pwStepLine":8,"gherkinStepLine":9,"keywordType":"Action","textWithKeyword":"When a user navigates to the homepage","stepMatchArguments":[]},{"pwStepLine":9,"gherkinStepLine":10,"keywordType":"Outcome","textWithKeyword":"Then the user sees \"Hello, Polaris!\" displayed on the page","stepMatchArguments":[{"group":{"start":14,"value":"\"Hello, Polaris!\"","children":[{"start":15,"value":"Hello, Polaris!","children":[{"children":[]}]},{"children":[{"children":[]}]}]},"parameterTypeName":"string"}]}]},
]; // bdd-data-end