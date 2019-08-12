# Fediverse Poll Bot
_Bot for scraping the fediverse for polls_

Use the `/api/v1/timelines/public` [api](https://docs.joinmastodon.org/api/rest/timelines/#get-api-v1-timelines-public) to grab posts from a public feed. The post indexed `0` will be the most recent, the bot should then make another call to `/api/v1/timelines/public?since_id={status_id}`. If the `poll` portion of the status json is not `null` then we have a poll status.

Continue requesting with a renewed `since_id` until the api response returns less than 20 status; at this point halt and wait 15 seconds before retrying, if that response has less than 20 status's wait 30 seconds. Continue doing this cool down to a max of five minutes (300 seconds.)

Once the bot has a poll status it should store it and if the poll is still open schedule an hourly job for updating the stats (we don't need smaller resolution that this and really don't want to hammer any server) we should then have a database row containing the polls meta that gets updated hourly up until the time the poll is completed.

I will need to update myself on the etique of this, but it may be nessessary for each poll status to double check the authors account to ensure they have no #nobot set; if they do then we should ignore their status as they have asked for no bots to track them.

For the front end we should have the polls segmented into the following filters: _Currently Open_, _Closing in n days time_, _Recently Closed_ and _Closed_. Each open poll will have a refresh button/link that the visitor can use to manually prompt an update of the stats if they decide those displayed are too out of date. I am thinking something very simple, along the lines of a paginated grid with a heading. Maybe including a search box for finding polls. Each poll should link through to the status on the source domain.

It would be nice to collect some agregate stats for things like polls opened/closed in the past 30 days, total votes cast in the past 30 days, etc maybe with a graph showing open polls over time, votes over time, etc.

The bot should have some fediverse presence so that an account can `@` the bot with words to the effect of "Forget Me" or simply "#nobot" and have any poll status found linked to that account imedietly deleted from the bots database. Similarly if someone has polls in their history that aren't found on the bots website due to being from before the bot going live, they coult message with a command like "Scrape Me". If someone has asked the bot to forget them they can undo it with "Remember Me" and the bot will begin including polls they author into its collection, they will need to ask the bot to "Scrape Me" if they wish to have their historical polls re-included.

Usage of "Remember Me" and "Scrape Me" commands will negate the `#nobot` flag in the users bio as these direct requsts give the bot permission to scrape.

### Rules of Good Bot Behaviour

1. The bot should only scrape public statuses
2. The bot should adhere to #nobot flags in user bios unless permission is granted via bot commands
3. The bot should forget a user if asked, with zero friction and imediate effect
4. The bot should be aware of how many requests it makes on a per domain^minute basis and govern its usage so not to be a nucance
5. The bot should adhere to any 401/403/405 responses which may come about from server admins manually firewalling the bot; this shouldn't happen but if it does we should stop making requests and add the domain to a do-not-knock list
