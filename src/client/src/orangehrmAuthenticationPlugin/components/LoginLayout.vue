<template>
  <div class="orangehrm-login-layout">
    <div class="orangehrm-login-layout-blob">
      <div class="orangehrm-login-container">
        <div class="orangehrm-login-slot-wrapper">
          <login-branding :img-src="loginBannerSrc"></login-branding>
          <div class="orangehrm-login-slot">
            <!-- <div class="orangehrm-login-logo-mobile">
              <img :src="loginLogoSrc" alt="orangehrm-logo" />
            </div> -->
            <slot></slot>
          </div>
        </div>
      </div>
      <!-- <div class="orangehrm-login-logo">
        <img :src="loginLogoSrc" alt="orangehrm-logo" />
      </div> -->
    </div>
  </div>
</template>

<script>
import LoginBranding from './LoginBranding';

export default {
  name: 'LoginLayout',
  components: {
    'login-branding': LoginBranding,
  },
  props: {
    loginLogoSrc: {
      type: String,
      required: true,
    },
    loginBannerSrc: {
      type: String,
      required: true,
    },
  },
};
</script>

<style src="./login-layout.scss" lang="scss" scoped></style>
