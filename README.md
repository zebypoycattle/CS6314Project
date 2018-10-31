# CS6314Project
Course Registration Web Application for CS 6314 Fall 2018 with Dr. Yuruk
Specifications
User Signup: Form with login or new user button. If new user selected, taken to create account form. This form will have a field that creates either admin or student account with appropriate options.

Searching items: Items are classes to enroll in. Possible filtering fields are:
  - Classification: Graduate/Undergraduate
  - Location: On-Campus/Online
Can search for a specific course by department and course number, which will bring up all sections of that course.

Favorites list: Schedule planner. Can add any courses to favorites list. Courses move from favorites to shopping cart (add to cart button) which is schedule to enroll. Can remove courses by remove button. Save button to save favorite list.

Cart: List of courses that student is choosing to enroll in. Courses in cart can not conflict based on time and/or course number, course history, and cannot exceed max enrollment. Save button and checkout button. Remove course button. (Swap courses?)

Checkout: After enrolling, course schedule for student will appear. If any courses could not be scheduled (lack prereq or not open) information will be displayed below. (wait list?)

History: Student profile will have a history with course informaiton from previous semesters.

Current structure:
Homepage for login ---> New User Account Creation

Filter and Search for Courses --> Favorite (Schedule Planner) --> Cart (Schedule Enrollment) --> Checkout (Show enrollment)
  
Logout option on any page.
