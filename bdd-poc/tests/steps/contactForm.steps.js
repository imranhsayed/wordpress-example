import { expect } from '@playwright/test';
import { createBdd } from 'playwright-bdd';

const { Given, When, Then } = createBdd();

Given("I navigate to the page {string}",async({page}, pageURL)=>{
	await page.goto(pageURL)
	console.log(`Navigate to the contact page ${pageURL}`)
})

When("I enter the First name {string}", async({page}, fName)=>{
	await page.locator(`#input_1_1_3`).fill(fName);
	console.log(`Enter the first name ${fName}`)
})

When("I enter the last name {string}", async({page}, lName)=>{
	await page.locator(`#input_1_1_6`).fill(lName);
	console.log(`Enter the last name ${lName}`)
})

When("I enter the email {string}", async({page}, email)=>{
	await page.locator(`#input_1_2`).fill(email);
	console.log(`Enter the email ${email}`)
})

When("I enter the confirm email {string}", async({page}, email)=>{
	await page.locator(`#input_1_2_2`).fill(email);
	console.log(`Enter the confirm email ${email}`)
})

When("I enter the comments {string}", async({page}, comm)=>{
	await page.locator(`#input_1_3`).fill(comm);
	console.log(`Enter the comments ${comm}`)
})

When("I click on the submit button", async({page})=>{
	await page.locator(`#gform_submit_button_1`).click()
	console.log("Click on the submit button")
})

Then("The form should be successfully submitted", async({page})=>{
	await expect(page.locator("#gform_confirmation_message_1")).toBeVisible()
	console.log("The form should be successfully submitted")
})
