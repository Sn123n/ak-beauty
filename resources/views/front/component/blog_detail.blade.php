@include('front.layouts.header')
<div class="main">
    <section class="blog-detail">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <article class="blog-post">
                        <header class="blog-header">
                            <h1 class="blog-title">{{ $meta_title ?? 'Blog Post' }}</h1>
                            <div class="blog-meta">
                                <span class="blog-date">
                                    <i class="fas fa-calendar"></i>
                                    {{ \Carbon\Carbon::now()->format('F d, Y') }}
                                </span>
                                <span class="blog-author">
                                    <i class="fas fa-user"></i>
                                    AK Beauty Store Team
                                </span>
                                <span class="blog-category">
                                    <i class="fas fa-tag"></i>
                                    Nail Art Tips
                                </span>
                            </div>
                        </header>
                        
                        <div class="blog-content">
                            <div class="featured-image">
                                <img src="{{ asset('client_assets/images/blog-featured.jpg') }}" alt="Blog Featured Image">
                            </div>
                            
                            <div class="blog-text">
                                <h2>Introduction</h2>
                                <p>Welcome to our comprehensive guide on nail art and extensions. In this article, we'll explore the latest trends, techniques, and products that can help you achieve salon-quality nails at home.</p>
                                
                                <h2>Choosing the Right Products</h2>
                                <p>When it comes to nail art, selecting the right products is crucial for achieving professional results. Here are some key considerations:</p>
                                <ul>
                                    <li>Quality of materials and ingredients</li>
                                    <li>Compatibility with your nail type</li>
                                    <li>Ease of application and removal</li>
                                    <li>Longevity and durability</li>
                                </ul>
                                
                                <h2>Popular Nail Art Techniques</h2>
                                <p>Modern nail art offers numerous techniques to express your creativity:</p>
                                
                                <h3>1. PolyGel Extensions</h3>
                                <p>PolyGel has revolutionized the nail industry with its unique combination of acrylic hardness and gel flexibility. This innovative product allows for stronger, lighter, and more flexible nail enhancements.</p>
                                
                                <h3>2. Press-On Nails</h3>
                                <p>Perfect for beginners and those who want quick, beautiful results without the commitment. Modern press-on nails come in various designs and can last for weeks with proper application.</p>
                                
                                <h3>3. Nail Stamping</h3>
                                <p>Create intricate designs effortlessly using stamping plates and special polishes. This technique allows for consistent, professional-looking patterns every time.</p>
                                
                                <h2>Tips for Long-Lasting Nail Art</h2>
                                <p>To ensure your nail art lasts as long as possible:</p>
                                <ol>
                                    <li>Always start with clean, dry nails</li>
                                    <li>Apply a quality base coat</li>
                                    <li>Seal edges properly to prevent chipping</li>
                                    <li>Use a top coat for added protection</li>
                                    <li>Avoid exposing nails to harsh chemicals</li>
                                    <li>Moisturize cuticles regularly</li>
                                </ol>
                                
                                <h2>Trending Colors and Designs</h2>
                                <p>This season's hottest nail trends include:</p>
                                <ul>
                                    <li>Nude and neutral tones</li>
                                    <li>Abstract geometric patterns</li>
                                    <li>Metallic finishes</li>
                                    <li>Ombre and gradient effects</li>
                                    <li>Minimalist designs with accent nails</li>
                                </ul>
                                
                                <h2>Conclusion</h2>
                                <p>Nail art is a wonderful way to express your personal style and creativity. With the right products, techniques, and care, you can achieve beautiful, long-lasting results that rival professional salon services. Remember to practice regularly and don't be afraid to experiment with different styles and designs.</p>
                                
                                <p>For more tips and tutorials, be sure to check out our other blog posts and video guides. Happy nail art-ing!</p>
                            </div>
                        </div>
                        
                        <footer class="blog-footer">
                            <div class="blog-tags">
                                <h4>Tags:</h4>
                                <div class="tags">
                                    <span class="tag">Nail Art</span>
                                    <span class="tag">PolyGel</span>
                                    <span class="tag">Press-On Nails</span>
                                    <span class="tag">Nail Extensions</span>
                                    <span class="tag">Beauty Tips</span>
                                </div>
                            </div>
                            
                            <div class="blog-share">
                                <h4>Share this article:</h4>
                                <div class="social-links">
                                    <a href="#" class="social-link facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="#" class="social-link twitter">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="#" class="social-link instagram">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                    <a href="#" class="social-link pinterest">
                                        <i class="fab fa-pinterest"></i>
                                    </a>
                                    <a href="#" class="social-link whatsapp">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                </div>
                            </div>
                        </footer>
                    </article>
                    
                    <div class="related-posts">
                        <h3>Related Articles</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="related-post">
                                    <div class="post-image">
                                        <img src="{{ asset('client_assets/images/blog-1.jpg') }}" alt="Related Post">
                                    </div>
                                    <div class="post-content">
                                        <h4><a href="#">Beginner's Guide to PolyGel Nails</a></h4>
                                        <p>Everything you need to know about getting started with PolyGel...</p>
                                        <span class="post-date">March 15, 2024</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="related-post">
                                    <div class="post-image">
                                        <img src="{{ asset('client_assets/images/blog-2.jpg') }}" alt="Related Post">
                                    </div>
                                    <div class="post-content">
                                        <h4><a href="#">Top 10 Nail Art Trends for 2024</a></h4>
                                        <p>Discover the hottest nail art trends that are dominating this year...</p>
                                        <span class="post-date">March 10, 2024</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="blog-sidebar">
                        <div class="sidebar-widget">
                            <h3>Search</h3>
                            <div class="search-form">
                                <input type="text" placeholder="Search articles..." class="form-control">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="sidebar-widget">
                            <h3>Categories</h3>
                            <ul class="categories">
                                <li><a href="#">Nail Art Tips (12)</a></li>
                                <li><a href="#">Product Reviews (8)</a></li>
                                <li><a href="#">Tutorials (15)</a></li>
                                <li><a href="#">Trends (6)</a></li>
                                <li><a href="#">Care & Maintenance (9)</a></li>
                            </ul>
                        </div>
                        
                        <div class="sidebar-widget">
                            <h3>Recent Posts</h3>
                            <ul class="recent-posts">
                                <li>
                                    <div class="post-thumb">
                                        <img src="{{ asset('client_assets/images/blog-thumb-1.jpg') }}" alt="Post">
                                    </div>
                                    <div class="post-info">
                                        <h4><a href="#">How to Apply Press-On Nails Like a Pro</a></h4>
                                        <span>March 18, 2024</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="post-thumb">
                                        <img src="{{ asset('client_assets/images/blog-thumb-2.jpg') }}" alt="Post">
                                    </div>
                                    <div class="post-info">
                                        <h4><a href="#">Best Nail Colors for Spring 2024</a></h4>
                                        <span>March 16, 2024</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="post-thumb">
                                        <img src="{{ asset('client_assets/images/blog-thumb-3.jpg') }}" alt="Post">
                                    </div>
                                    <div class="post-info">
                                        <h4><a href="#">Nail Care Routine for Healthy Nails</a></h4>
                                        <span>March 14, 2024</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="sidebar-widget">
                            <h3>Popular Tags</h3>
                            <div class="tag-cloud">
                                <span class="tag">PolyGel</span>
                                <span class="tag">Press-On</span>
                                <span class="tag">Nail Art</span>
                                <span class="tag">Extensions</span>
                                <span class="tag">DIY</span>
                                <span class="tag">Trends</span>
                                <span class="tag">Tutorial</span>
                                <span class="tag">Reviews</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
.blog-detail {
    padding: 2rem 0;
}

.blog-post {
    background: white;
    border-radius: 8px;
    padding: 2rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
}

.blog-header {
    margin-bottom: 2rem;
    text-align: center;
}

.blog-title {
    font-size: 2.5rem;
    font-weight: bold;
    color: #333;
    margin-bottom: 1rem;
}

.blog-meta {
    display: flex;
    justify-content: center;
    gap: 2rem;
    color: #666;
    font-size: 0.9rem;
}

.blog-meta span {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.featured-image {
    margin-bottom: 2rem;
}

.featured-image img {
    width: 100%;
    border-radius: 8px;
    height: 400px;
    object-fit: cover;
}

.blog-text h2 {
    font-size: 1.8rem;
    color: #333;
    margin: 2rem 0 1rem 0;
}

.blog-text h3 {
    font-size: 1.4rem;
    color: #333;
    margin: 1.5rem 0 1rem 0;
}

.blog-text p {
    font-size: 1.1rem;
    line-height: 1.6;
    color: #555;
    margin-bottom: 1rem;
}

.blog-text ul, .blog-text ol {
    margin: 1rem 0 1rem 2rem;
}

.blog-text li {
    font-size: 1.1rem;
    line-height: 1.6;
    color: #555;
    margin-bottom: 0.5rem;
}

.blog-footer {
    margin-top: 3rem;
    padding-top: 2rem;
    border-top: 1px solid #eee;
}

.blog-tags, .blog-share {
    margin-bottom: 2rem;
}

.blog-tags h4, .blog-share h4 {
    font-size: 1.2rem;
    margin-bottom: 1rem;
    color: #333;
}

.tags, .tag-cloud {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.tag {
    background: #f8f9fa;
    color: #555;
    padding: 0.3rem 0.8rem;
    border-radius: 20px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.tag:hover {
    background: #007bff;
    color: white;
}

.social-links {
    display: flex;
    gap: 1rem;
}

.social-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
}

.social-link.facebook { background: #3b5998; }
.social-link.twitter { background: #1da1f2; }
.social-link.instagram { background: #e1306c; }
.social-link.pinterest { background: #bd081c; }
.social-link.whatsapp { background: #25d366; }

.social-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.related-posts {
    background: white;
    border-radius: 8px;
    padding: 2rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.related-posts h3 {
    font-size: 1.5rem;
    margin-bottom: 1.5rem;
    color: #333;
}

.related-post {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.post-image img {
    width: 120px;
    height: 80px;
    object-fit: cover;
    border-radius: 4px;
}

.post-content h4 {
    font-size: 1rem;
    margin-bottom: 0.5rem;
}

.post-content h4 a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
}

.post-content h4 a:hover {
    color: #007bff;
}

.post-content p {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 0.5rem;
}

.post-date {
    font-size: 0.8rem;
    color: #999;
}

.blog-sidebar {
    position: sticky;
    top: 2rem;
}

.sidebar-widget {
    background: white;
    border-radius: 8px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.sidebar-widget h3 {
    font-size: 1.3rem;
    margin-bottom: 1rem;
    color: #333;
}

.search-form {
    display: flex;
    gap: 0.5rem;
}

.search-form input {
    flex: 1;
}

.categories li, .recent-posts li {
    margin-bottom: 0.8rem;
}

.categories li a {
    color: #555;
    text-decoration: none;
    transition: color 0.3s ease;
}

.categories li a:hover {
    color: #007bff;
}

.recent-posts li {
    display: flex;
    gap: 1rem;
}

.post-thumb img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 4px;
}

.post-info h4 {
    font-size: 0.9rem;
    margin-bottom: 0.3rem;
}

.post-info h4 a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
}

.post-info h4 a:hover {
    color: #007bff;
}

.post-info span {
    font-size: 0.8rem;
    color: #999;
}

@media (max-width: 768px) {
    .blog-title {
        font-size: 2rem;
    }
    
    .blog-meta {
        flex-direction: column;
        gap: 0.5rem;
        text-align: left;
    }
    
    .featured-image img {
        height: 250px;
    }
    
    .related-post {
        flex-direction: column;
    }
    
    .post-image img {
        width: 100%;
        height: 150px;
    }
}
</style>

@include('front.layouts.footer')
