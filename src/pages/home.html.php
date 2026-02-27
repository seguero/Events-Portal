      <!-- Quick intro / page header -->
      <header class="page-header">
        <h1>Welcome</h1>
        <p>
          Discover upcoming workshops, recent highlights, and the latest
          updates.
        </p>
      </header>

      <!-- Popular events:
           uses the full card layout (image + badge + meta + CTA).
           later this section can become a carousel without changing the card markup -->
      <section class="block" aria-labelledby="popular-heading">
        <div class="block-head">
          <h2 id="popular-heading">Popular events</h2>
          <a class="block-link" href="events.html">View all</a>
        </div>

        <div class="cards">
          <article class="card">
            <img
              class="card-media"
              src="../assets/placeholder.jpg"
              alt="Event"
            />
            <div class="card-body">
              <span class="badge">Event</span>
              <h3 class="card-title">Title</h3>
              <p class="card-meta">Tue 17 Feb · Northampton</p>
              <p class="card-text">Event description</p>
              <a class="card-cta" href="event.html">Read more</a>
            </div>
          </article>

          <article class="card">
            <img
              class="card-media"
              src="../assets/placeholder.jpg"
              alt="Event 2"
            />
            <div class="card-body">
              <span class="badge badge--accent">Event 2</span>
              <h3 class="card-title">Title 2</h3>
              <p class="card-meta">Wed 18 Feb - Wellingborough</p>
              <p class="card-text">Event 2 description</p>
              <a class="card-cta" href="event.html">Read more</a>
            </div>
          </article>

          <article class="card">
            <img
              class="card-media"
              src="../assets/placeholder.jpg"
              alt="Event 3"
            />
            <div class="card-body">
              <span class="badge">Event 3</span>
              <h3 class="card-title">Title 3</h3>
              <p class="card-meta">Thu 19 Feb - Kettering</p>
              <p class="card-text">Event 3 description</p>
              <a class="card-cta" href="event.html">Read more</a>
            </div>
          </article>
        </div>
      </section>

      <!-- Latest events:
           compact layout (row-style cards) for quick scanning -->
      <section class="block" aria-labelledby="latest-heading">
        <div class="block-head">
          <h2 id="latest-heading">Latest events</h2>
          <a class="block-link" href="events.html?sort=latest">See recent</a>
        </div>

        <div class="cards cards--compact">
          <article class="card card--row">
            <div class="card-body">
              <h3 class="card-title">Latest Event 1</h3>
              <p class="card-meta">Added x days ago</p>
              <p class="card-text">Latest Event 1 description</p>
              <a class="card-cta" href="event.html">Read more</a>
            </div>
          </article>

          <article class="card card--row">
            <div class="card-body">
              <h3 class="card-title">Latest Event 2</h3>
              <p class="card-meta">Added x days ago</p>
              <p class="card-text">Latest Event 2 description</p>
              <a class="card-cta" href="event.html">Read more</a>
            </div>
          </article>
        </div>
      </section>

      <!-- Blog updates:
           same card component, just without images for now -->
      <section class="block" aria-labelledby="blog-heading">
        <div class="block-head">
          <h2 id="blog-heading">Blog updates</h2>
          <a class="block-link" href="blog.html">All blog posts</a>
        </div>

        <div class="cards">
          <article class="card">
            <div class="card-body">
              <span class="badge">Update</span>
              <h3 class="card-title">Update x.x</h3>
              <p class="card-meta">17 Feb 2026</p>
              <p class="card-text">Blog update</p>
              <a class="card-cta" href="blog.html">Read more</a>
            </div>
          </article>
        </div>
      </section>