import { expect } from '@playwright/test';
import { only } from 'node:test';
import { createBdd } from 'playwright-bdd';

const { Given, When, Then } = createBdd();

Given("the homepage is deployed to production", async({page})=>{
	console.log("The homepage is deployed to production");
})

When("a user navigates to the homepage", async({page})=>{
	await page.goto("https://rishav.rt.gw/")
})

Then("the user sees {string} displayed on the page", async({page}, text)=>{
	await expect(page.locator(".entry-content.alignfull")).toContainText(text)
})