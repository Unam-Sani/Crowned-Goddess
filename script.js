document.addEventListener('DOMContentLoaded', function() {
  // Set minimum date for booking form
  const dateInput = document.getElementById('date');
  const today = new Date().toISOString().split('T')[0];
  dateInput.setAttribute('min', today);

  // Function to disable past times for the current date
  function disablePastTimes() {
      const timeInput = document.getElementById('time');
      const selectedDate = new Date(dateInput.value);
      const now = new Date();

      // Clear previous disabled times
      const options = timeInput.querySelectorAll('option');
      options.forEach(option => {
          option.disabled = false;
      });

      if (selectedDate.toDateString() === now.toDateString()) {
          const currentTime = now.getHours();
          options.forEach(option => {
              const optionTime = parseInt(option.value.split(':')[0], 10);
              if (optionTime <= currentTime) {
                  option.disabled = true;
              }
          });
      }
  }

  dateInput.addEventListener('change', disablePastTimes);
  disablePastTimes();

  // Booking form submission
  document.getElementById('bookingForm').addEventListener('submit', function(event) {
      event.preventDefault();

      const date = document.getElementById('date').value;
      const time = document.getElementById('time').value;
      const email = document.getElementById('email').value;
      const to_name = document.getElementById('name').value;

      const booking = { date, time, email };

      // Read existing bookings from local storage or create an empty array if none exist
      const bookings = JSON.parse(localStorage.getItem('bookings')) || [];

      // Check if the date already has 4 bookings
      const bookingsOnDate = bookings.filter(b => b.date === date);
      if (bookingsOnDate.length >= 4) {
          swal('Choose another day. Maximum bookings for the day reached', '', 'warning');
          return;
      }

      // Check if the time slot on the given date is already booked
      const existingBooking = bookingsOnDate.find(b => b.time === time);
      if (existingBooking) {
          swal('Choose another day. Time slot already booked', '', 'warning');
          return;
      }

      // Add the new booking
      bookings.push(booking);
      localStorage.setItem('bookings', JSON.stringify(bookings));

      // Send confirmation email using EmailJS
      emailjs.send("service_l7u30y8", "template_ztayu9q", {
          to_name: to_name,
          from_name: "Crowned Goddess",
          to_email: email,
          date: date,
          time: time
      })
      .then(function(response) {
          swal('Booking confirmed! Confirmation email sent to ' + email, '', 'success');
      }, function(error) {
          console.error('Failed to send confirmation email:', error);
          swal('Failed to send confirmation email: ' + JSON.stringify(error), '', 'error');
      });

      // Clear the form
      document.getElementById('bookingForm').reset();
  });

  // Header scroll behavior
  const header = document.querySelector('header');
  const fixedNavBar = () => {
      header.classList.toggle('scrolled', window.pageYOffset > 0);
  };
  fixedNavBar();
  window.addEventListener('scroll', fixedNavBar);

  // Navbar toggle
  let menu = document.querySelector('#menu-btn');
  let userBtn = document.querySelector('#user-btn');
  menu.addEventListener('click', () => {
      let nav = document.querySelector('.navbar');
      nav.classList.toggle('active');
  });
  userBtn.addEventListener('click', () => {
      let userBox = document.querySelector('.user-box');
      userBox.classList.toggle('active');
  });

  // Home page slider
  const leftArrow = document.querySelector('.left-arrow');
  const rightArrow = document.querySelector('.right-arrow');
  const slides = document.querySelectorAll('.slider_slider');
  let currentSlide = 0;
  const scrollRight = () => {
      currentSlide = (currentSlide >= slides.length - 1) ? 0 : currentSlide + 1;
      showSlide(currentSlide);
  };
  const scrollLeft = () => {
      currentSlide = (currentSlide <= 0) ? slides.length - 1 : currentSlide - 1;
      showSlide(currentSlide);
  };
  const showSlide = (index) => {
      slides.forEach((slide, i) => {
          slide.style.display = (i === index) ? 'block' : 'none';
      });
  };
  showSlide(currentSlide);
  leftArrow.addEventListener('click', () => {
      scrollLeft();
      resetTimer();
  });
  rightArrow.addEventListener('click', () => {
      scrollRight();
      resetTimer();
  });
  let timerId = setInterval(scrollRight, 7000);
  const resetTimer = () => {
      clearInterval(timerId);
      timerId = setInterval(scrollRight, 7000);
  };

  // Testimonial slides
  let testimonialSlides = document.querySelectorAll('.testimonial-item');
  let testimonialIndex = 0;
  const showTestimonialSlide = (n) => {
      testimonialSlides.forEach((slide, i) => {
          slide.classList.toggle('active', i === n);
      });
  };
  const nextTestimonialSlide = () => {
      testimonialIndex = (testimonialIndex + 1) % testimonialSlides.length;
      showTestimonialSlide(testimonialIndex);
  };
  const prevTestimonialSlide = () => {
      testimonialIndex = (testimonialIndex - 1 + testimonialSlides.length) % testimonialSlides.length;
      showTestimonialSlide(testimonialIndex);
  };
  document.querySelector('.testimonial .left-arrow').addEventListener('click', prevTestimonialSlide);
  document.querySelector('.testimonial .right-arrow').addEventListener('click', nextTestimonialSlide);
  showTestimonialSlide(testimonialIndex);
});
