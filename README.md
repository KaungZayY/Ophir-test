# Social Media App

## Overview

A simple social media application built using Laravel, featuring user authentication, post management, and commenting functionalities.

## Database Structure

- **Users**
  - `id` (Primary Key)
  - `name`
  - `email`
  - `password`

- **Posts**
  - `id` (Primary Key)
  - `user_id` (Foreign Key)
  - `title`
  - `body`

- **Comments**
  - `id` (Primary Key)
  - 'user_id' (Foreign Key)
  - `post_id` (Foreign Key)
  - `text`

## Functionalities

### Users
- Sign Up New Account
- Login

### Posts
- Create, Edit, and Delete Posts (Users can only edit/delete their own posts)

### Comments
- Add, Edit, and Delete Comments (Users can only edit/delete their own comments; Post owners can delete any comment on their posts)

## News Feed Page

Displays posts from all users. Logged-in users can view and comment on posts.

## Detail Page

Shows post details and a list of comments. Users can add comments here.

---

This project provides essential social media features using Laravel, focusing on user interaction with posts and comments. Explore and expand it further as needed!
