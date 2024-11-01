<template>
  <oxd-layout
    :class="{
      'orangehrm-upgrade-layout': showUpgrade,
    }"
    v-bind="$attrs"
  >
    <template v-for="(_, name) in $slots" #[name]="slotData">
      <slot :name="name" v-bind="slotData" />
    </template>
    <template v-if="showUpgrade" #topbar-header-right-area>
      <upgrade-button v-if="showUpgrade" />
    </template>
    <template #user-actions>
      <li>
        <a
          href="#"
          role="menuitem"
          class="oxd-userdropdown-link"
          @click="openAboutModel"
        >
          {{ $t('general.about') }}
        </a>
      </li>
      <li>
        <a :href="supportUrl" role="menuitem" class="oxd-userdropdown-link">
          {{ $t('general.support') }}
        </a>
      </li>
      <li v-if="updatePasswordUrl">
        <a
          :href="updatePasswordUrl"
          role="menuitem"
          class="oxd-userdropdown-link"
        >
          {{ $t('general.change_password') }}
        </a>
      </li>
      <li>
        <a :href="logoutUrl" role="menuitem" class="oxd-userdropdown-link">
          {{ $t('general.logout') }}
        </a>
      </li>
    </template>
    <!-- <template #nav-actions>
      <oxd-icon-button
        name="question-lg"
        :title="$t('general.help')"
        @click="onClickSupport"
      />
    </template> -->
  </oxd-layout>
  <about v-if="showAboutModel" @close="closeAboutModel"></about>
</template>

<script>
import {provide, readonly, ref} from 'vue';
import About from '@/core/pages/About.vue';
import {OxdLayout} from '@ohrm/oxd';
import {dateFormatKey} from '@/core/util/composable/useDateFormat';
import UpgradeButton from '@/core/components/buttons/UpgradeButton.vue';

export default {
  components: {
    about: About,
    'oxd-layout': OxdLayout,
    'upgrade-button': UpgradeButton,
  },
  inheritAttrs: false,
  props: {
    permissions: {
      type: Object,
      default: () => ({}),
    },
    logoutUrl: {
      type: String,
      default: '#',
    },
    supportUrl: {
      type: String,
      default: '#',
    },
    updatePasswordUrl: {
      type: String,
      default: '#',
    },
    dateFormat: {
      type: Object,
      default: null,
    },
    // helpUrl: {
    //   type: String,
    //   default: null,
    // },
    showUpgrade: {
      type: Boolean,
      default: false,
    },
  },
  setup(props) {
    const showAboutModel = ref(false);
    provide('permissions', readonly(props.permissions));
    provide(dateFormatKey, readonly(props.dateFormat));

    const openAboutModel = () => {
      showAboutModel.value = true;
    };

    const closeAboutModel = () => {
      showAboutModel.value = false;
    };

    // const onClickSupport = () => {
    //   if (props.helpUrl) window.open(props.helpUrl, '_blank');
    // };

    return {
      // onClickSupport,
      showAboutModel,
      openAboutModel,
      closeAboutModel,
    };
  },
};
</script>

<style lang="scss">
.orangehrm-upgrade-layout {
  .oxd-topbar-header-userarea {
    align-self: center;
    margin-left: unset;
  }
}
.oxd-layout {
  .oxd-topbar-header {
    background-color: #286794;
    background-image: linear-gradient(90deg, #3679a9 0, #232324 90%);
  }
  .oxd-main-menu-item:hover {
    color: var(--oxd-primary-font-color, #fff);
    // background-color: #a6b6c1;
    background-color: #9dbbcf;
  }
  .oxd-main-menu-item.active {
    color: var(--oxd-primary-font-color, #fff);
    background-color: #286794;
    border-top-right-radius: 50px;
    border-bottom-right-radius: 50px;
    background-image: linear-gradient(90deg, #3679a9 0, #232324 90%);
    // background-image: linear-gradient(90deg, #b8ccd3 0, #2323 90%);
  }
  .oxd-sidepanel {
    top: 0;
    height: 100%;
    position: fixed;
    background-color: #b8ccd3;
    border-bottom-right-radius: 35px;
    border-top-right-radius: 35px;
    box-shadow: 0 25px 35px #0000002e;
    z-index: 230;
    transition: width 0.3s ease-in-out;
  }
  .oxd-main-menu-button {
    top: 110px;
    right: -12px;
    width: 25px;
    height: 25px;
    display: inline-flex;
    min-width: 25px;
    min-height: 25px;
    position: absolute;
    background-color: #286794 !important;
  }
  .oxd-button--secondary {
    color: var(--oxd-secondary-font-color, #fff);
    background-color: #286794;
    &:hover {
      background-color: #32739e;
    }
    &:focus {
      background-color: #32739e;
    }
  }
  .oxd-button--ghost {
    border: 1px solid;
    color: #286794;
    background-color: transparent;
    &:hover {
      color: #fff;
      background-color: #32739e;
    }
    &:focus {
      color: #fff;
      background-color: #32739e;
    }
  }
  .oxd-main-menu-search .oxd-input {
    border-radius: 0.65rem;
    border: unset;
    color: #64728c;
    min-height: unset;
    height: auto;
    width: auto;
    padding: 0.1rem 0.5rem;
    display: inline;
    font-size: 0.85rem;
    padding-left: 15px;
  }
}
</style>
