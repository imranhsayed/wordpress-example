// Generated from: tests/features/contactForm.feature
import { test } from "playwright-bdd";

test.describe('Verify Contact Form Submission', () => {

  test('Verify Successful Form Submission', async ({ Given, When, Then, page }) => { 
    await Given('I navigate to the page "https://rishav.rt.gw/contact-us-page/"', null, { page }); 
    await When('I enter the First name "Rishav"', null, { page }); 
    await When('I enter the last name "Dutta"', null, { page }); 
    await When('I enter the email "rishav.dutta2024@gmail.com"', null, { page }); 
    await When('I enter the confirm email "rishav.dutta2024@gmail.com"', null, { page }); 
    await When('I enter the comments "Test Comment"', null, { page }); 
    await When('I click on the submit button', null, { page }); 
    await Then('The form should be successfully submitted', null, { page }); 
  });

});

// == technical section ==

test.use({
  $test: [({}, use) => use(test), { scope: 'test', box: true }],
  $uri: [({}, use) => use('tests/features/contactForm.feature'), { scope: 'test', box: true }],
  $bddFileData: [({}, use) => use(bddFileData), { scope: "test", box: true }],
});

const bddFileData = [ // bdd-data-start
  {"pwTestLine":6,"pickleLine":7,"tags":[],"steps":[{"pwStepLine":7,"gherkinStepLine":8,"keywordType":"Context","textWithKeyword":"Given I navigate to the page \"https://rishav.rt.gw/contact-us-page/\"","stepMatchArguments":[{"group":{"start":23,"value":"\"https://rishav.rt.gw/contact-us-page/\"","children":[{"start":24,"value":"https://rishav.rt.gw/contact-us-page/","children":[{"children":[]}]},{"children":[{"children":[]}]}]},"parameterTypeName":"string"}]},{"pwStepLine":8,"gherkinStepLine":9,"keywordType":"Action","textWithKeyword":"When I enter the First name \"Rishav\"","stepMatchArguments":[{"group":{"start":23,"value":"\"Rishav\"","children":[{"start":24,"value":"Rishav","children":[{"children":[]}]},{"children":[{"children":[]}]}]},"parameterTypeName":"string"}]},{"pwStepLine":9,"gherkinStepLine":10,"keywordType":"Action","textWithKeyword":"When I enter the last name \"Dutta\"","stepMatchArguments":[{"group":{"start":22,"value":"\"Dutta\"","children":[{"start":23,"value":"Dutta","children":[{"children":[]}]},{"children":[{"children":[]}]}]},"parameterTypeName":"string"}]},{"pwStepLine":10,"gherkinStepLine":11,"keywordType":"Action","textWithKeyword":"When I enter the email \"rishav.dutta2024@gmail.com\"","stepMatchArguments":[{"group":{"start":18,"value":"\"rishav.dutta2024@gmail.com\"","children":[{"start":19,"value":"rishav.dutta2024@gmail.com","children":[{"children":[]}]},{"children":[{"children":[]}]}]},"parameterTypeName":"string"}]},{"pwStepLine":11,"gherkinStepLine":12,"keywordType":"Action","textWithKeyword":"When I enter the confirm email \"rishav.dutta2024@gmail.com\"","stepMatchArguments":[{"group":{"start":26,"value":"\"rishav.dutta2024@gmail.com\"","children":[{"start":27,"value":"rishav.dutta2024@gmail.com","children":[{"children":[]}]},{"children":[{"children":[]}]}]},"parameterTypeName":"string"}]},{"pwStepLine":12,"gherkinStepLine":13,"keywordType":"Action","textWithKeyword":"When I enter the comments \"Test Comment\"","stepMatchArguments":[{"group":{"start":21,"value":"\"Test Comment\"","children":[{"start":22,"value":"Test Comment","children":[{"children":[]}]},{"children":[{"children":[]}]}]},"parameterTypeName":"string"}]},{"pwStepLine":13,"gherkinStepLine":14,"keywordType":"Action","textWithKeyword":"When I click on the submit button","stepMatchArguments":[]},{"pwStepLine":14,"gherkinStepLine":15,"keywordType":"Outcome","textWithKeyword":"Then The form should be successfully submitted","stepMatchArguments":[]}]},
]; // bdd-data-end