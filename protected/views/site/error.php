<div class="error-page-wrapper">
  <div class="error-container">
    
    <!-- Left Content -->
    <div class="error-left">
      <h1 class="error-code">Oops!</h1>
      <h2 class="error-title">Something went wrong...</h2>
      <p class="error-message">
        Please try reloading the page. If the issue persists, contact us at 
        <a href="mailto:techsupport@softwaresuggest.com">techsupport@softwaresuggest.com</a> — we’ll be happy to help!
      </p>
      <a href="<?= Yii::app()->homeUrl; ?>" class="btn-back">
        Go Back Home
      </a>
    </div>

    <!-- Right Illustration -->
    <div class="error-right">
      <img src="<?= Yii::app()->baseUrl; ?>/images/404.png" alt="404 Illustration">
    </div>

  </div>
</div>

<style>
.error-page-wrapper {
  min-height: calc(100dvh - 42px);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 40px 20px;
  background: linear-gradient(180deg, #FEFFFF 0%, #D9E1F5 50%), #FAFAFE;
}

.error-container {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 60px;
  max-width: 1100px;
  width: 100%;
}

.error-left {
  flex: 1;
}

.error-code {
  color: #172B4C;
  font-size: 95px;
  font-weight: 600;
  margin: 0 0 20px;
}

.error-title {
  color: #172B4C;
  font-size: 36px;
  font-weight: 600;
  margin: 0;
}

.error-message {
  color: #6d7485;
  font-size: 15px;
  line-height: 1.6;
  max-width: 450px;
  margin: 28px 0 30px;
}

.error-message a {
  color: #0067C1;
  font-weight: 500;
}

.btn-back {
  display: inline-block;
  color: #FFFFFF;
  text-align: center;
  font-size: 15px;
  font-weight: 600;
  transition: 0.3s ease;
  border-radius: 6px !important;
  background: #191E45;
  padding: 15px 0;
  width: 250px;
  transition: all 0.3s ease;
}

.btn-back:hover {
  transform: scale(1.05);
  color: #FFFFFF;
  text-decoration: none;
}

.error-right {
  flex: 1;
  display: flex;
  justify-content: center;
}

.error-right img {
  max-width: 420px;
  width: 100%;
}

/* Responsive */
@media (max-width: 768px) {
  .error-container {
    flex-direction: column-reverse;
    text-align: center;
    gap: 30px;
  }

  .error-right img {
    max-width: 300px;
  }

  .error-message {
    margin: 0 auto 25px;
  }
}
</style>
