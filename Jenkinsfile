pipeline {
  agent {
    node {
      label 'x201'
    }

  }
  stages {
    stage('Checkout') {
      steps {
        git(url: 'https://github.com/lindynetech/tms.git', branch: 'master')
      }
    }

  }
  environment {
    COMLETED_MSG = 'Build done!'
  }
}