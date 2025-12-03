import { expect } from '@playwright/test';
import { only } from 'node:test';
import { createBdd } from 'playwright-bdd';

const { Given, When, Then } = createBdd();

Given("I am on the WordPress login page", async({page})=>{
	console.log("Navigate to WordPress login page");
})

When("I enter a valid username and password", async({page})=>{
	console.log("Entered valid username and password and clicked login");
})

Then("I should see a welcome message", async({page})=>{
	console.log("Successfully redirected to WordPress dashboard");
})